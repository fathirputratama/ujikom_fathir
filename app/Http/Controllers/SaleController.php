<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Member;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['member', 'user']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('member', function ($q2) use ($search) {
                    $q2->where('name', 'ilike', "%{$search}%"); // gunakan ilike untuk case-insensitive di PostgreSQL
                })
                ->orWhereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'ilike', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%")
                ->orWhereRaw("CAST(created_at AS TEXT) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("CAST(total_price AS TEXT) LIKE ?", ["%{$search}%"]);
            });
        }
        $sales = $query->latest()->paginate(10)->withQueryString();
        return view('sales.index', compact('sales'));
    }

    public function create(Request $request)
    {
        $search = $request->search;
        $products = Product::when($search, function ($query, $search) {
            return $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        })->get();
        return view('sales.create', compact('products'));
    }

    public function checkout(Request $request)
    {
        $quantities = $request->input('quantity', []);
        $productIds = array_keys($quantities);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $selectedProducts = [];
        $totalPrice = 0;
        foreach ($quantities as $productId => $quantity) {
            if ($quantity > 0 && isset($products[$productId])) {
                $product = $products[$productId];
                if ($product->stock >= $quantity) {
                    $subtotal = $product->price * $quantity;
                    $selectedProducts[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'image' => $product->image,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ];
                    $totalPrice += $subtotal;
                }
            }
        }
        if (empty($selectedProducts)) {
            return redirect()->route('sales.create')->with('error', 'Pilih setidaknya satu produk.');
        }
        return view('sales.checkout', compact('selectedProducts', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'status' => 'required|in:member,non-member',
            'amount_paid' => 'required|numeric|min:0',
            'phone' => 'required_if:status,member|numeric|nullable',
            'member_name' => 'nullable|string|max:255',
            'points_to_use' => 'nullable|integer|min:0',
        ]);

        $productsData = $request->input('products');
        $selectedProducts = [];
        $totalPrice = 0;
        $productIds = collect($productsData)->pluck('id')->all();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        foreach ($productsData as $item) {
            $product = $products[$item['id']] ?? null;
            if (!$product || $product->stock < $item['quantity']) {
                return redirect()->route('sales.checkout')->with('error', 'Stok tidak mencukupi untuk produk: ' . ($product->name ?? 'Tidak Diketahui'))->withInput();
            }
            $subtotal = $product->price * $item['quantity'];
            $selectedProducts[] = [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal,
            ];
            $totalPrice += $subtotal;
        }

        if ($request->amount_paid < $totalPrice) {
            return redirect()->route('sales.checkout')->with('error', 'Jumlah pembayaran tidak mencukupi.')->withInput();
        }

        if ($request->status === 'member') {
            $phone = $request->phone;
            $member = Member::where('phone_number', $phone)->first();
            $amount_paid = $request->amount_paid;

            session([
                'selected_products' => $selectedProducts,
                'total_price' => $totalPrice,
                'phone' => $phone,
                'amount_paid' => $amount_paid,
            ]);

            if (!$request->has('use_points') && !$request->has('member_name')) {
                return redirect()->route('sales.member');
            }

            $pointUsed = 0;
            $memberId = null;

            if (!$member){
                $request->validate([
                    'member_name' => 'required|string|max:255',
                ]);

                $member = Member::create([
                    'name' => $request->member_name,
                    'phone_number' => $phone,
                    'point' => 0,
                ]);
            } else {
                if ($request->has('use_points') && $request->input('use_points')) {
                    $pointUsed = min($member->point, $totalPrice);
                    $totalPrice -= $pointUsed;

                    if($totalPrice < 0){
                        return redirect()->route('sales.member')->with('error', 'Potongan poin melebihi harga.')->withInput();
                    }
                }
    }

            $memberId = $member->id;

            if($request->amount_paid < $totalPrice){
                return redirect()->route('sales.member')->with('error', 'Jumlah pembayaran tidak mencukupi.')->withInput();
            }

            $sale = DB::transaction(function () use ($request, $productsData, $products, $totalPrice, $memberId, $pointUsed, $member) {
                $sale = Sale::create([
                    'user_id' => Auth::id(),
                    'member_id' => $memberId,
                    'total_price' => $totalPrice,
                    'amount_paid' => $request->amount_paid,
                    'change' => $request->amount_paid - $totalPrice,
                    'points_used' => $pointUsed,
                    'customer_name' => $member->name,
                ]);

                foreach ($productsData as $item) {
                    $product = $products[$item['id']];
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'subtotal' => $product->price * $item['quantity'],
                    ]);
                    $product->decrement('stock', $item['quantity']);
                }

                if ($pointUsed > 0) {
                    $member->decrement('point', $pointUsed);
                }

                $newPoints = floor($totalPrice / 100);
                $member->increment('point', $newPoints);

                return $sale;
            });

            session()->forget(['selected_products', 'total_price', 'phone', 'amount_paid']);

            return redirect()->route('sales.result', $sale->id)->with('success', 'Penjualan berhasil. ID Penjualan: ' . $sale->id);
            }

            $sale = DB::transaction(function () use ($request, $productsData, $products, $totalPrice) {
                $sale = Sale::create([
                    'user_id' => Auth::id(),
                    'member_id' => null,
                    'total_price' => $totalPrice,
                    'amount_paid' => $request->amount_paid,
                    'change' => $request->amount_paid - $totalPrice,
                    'points_used' => 0,
                    'customer_name' => 'Non-Member',
                ]);

                foreach ($productsData as $item) {
                    $product = $products[$item['id']];
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'subtotal' => $product->price * $item['quantity'],
                    ]);
                    $product->decrement('stock', $item['quantity']);
                }

                return $sale;
            });

            session()->forget(['selected_products', 'total_price', 'phone', 'amount_paid']);

            return redirect()->route('sales.result', $sale->id)->with('success', 'Penjualan berhasil. ID Penjualan: ' . $sale->id);
    }

    public function member(Request $request){
        $selectedProducts = $request->input('selected_products', session('selected_products', []));
        if (empty($selectedProducts)) {
            return redirect()->route('sales.create')->with('error', 'Pilih produk terlebih dahulu.');
        }

        // Ambil data dari request atau session
        $selectedProducts = $request->input('selected_products', session('selected_products', []));
        $totalPrice = $request->input('total_price', session('total_price', 0));
        $phone = $request->input('phone', session('phone'));
        $amount_paid = $request->input('amount_paid', session('amount_paid', 0));

        // Cari member berdasarkan nomor telepon
        $member = $phone ? Member::where('phone_number', $phone)->first() : null;

        // Simpan data ke session untuk digunakan saat submit
        session([
            'selected_products' => $selectedProducts,
            'total_price' => $totalPrice,
            'phone' => $phone,
            'amount_paid' => $amount_paid,
        ]);

        return view('sales.member', compact('selectedProducts', 'totalPrice', 'member', 'phone', 'amount_paid'));
    }

    public function result($id){
        $sale = Sale::with(['saleDetails.product', 'member', 'user'])->findOrFail($id);
        return view('sales.result', compact('sale'));
    }

    public function downloadPDF($id){
        $sale = Sale::with(['saleDetails.product', 'member'])->findOrFail($id);
        $pdf = Pdf::loadView('sales.invoice', compact('sale'));
        return $pdf->download('sale' . $sale->id . '.pdf');
    }


}
