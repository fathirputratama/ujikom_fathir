<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Data grafik yang bisa dilihat oleh semua role
            $dailySales = Sale::selectRaw('DATE(created_at) as date, COUNT(*) as transactions')
                ->where('created_at', '>=', Carbon::today()->subDays(10))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->date => $item->transactions];
                });

            $productSales = SaleDetail::selectRaw('products.name, SUM(sale_details.quantity) as total_quantity')
                ->join('products', 'sale_details.product_id', '=', 'products.id')
                ->where('sale_details.created_at', '>=', Carbon::today()->subDays(10))
                ->groupBy('products.name')
                ->get()
                ->map(function ($item) {
                    return [
                        'name' => $item->name,
                        'total_quantity' => (int) $item->total_quantity,
                    ];
                });

            $totalSalesToday = Sale::whereDate('created_at', today())->count();
            $products = Product::where('stock', '>', 0)->orderBy('name')->get();
            $lastSale = Sale::latest('created_at')->first();
            $totalMemberSales = Sale::whereNotNull('member_id')->count();
            $totalNonMemberSales = Sale::whereNull('member_id')->count();

            return view('dashboard', compact(
                'dailySales',
                'productSales',
                'totalSalesToday',
                'products',
                'lastSale',
                'totalMemberSales',
                'totalNonMemberSales'
            ));
        } catch (\Exception $e) {
            Log::error('Error in DashboardController@index: ' . $e->getMessage());
            return view('dashboard', [
                'totalSalesToday' => 0,
                'products' => collect([]),
                'dailySales' => collect([]),
                'productSales' => collect([]),
                'totalMemberSales' => 0,
                'totalNonMemberSales' => 0,
            ]);
        }
    }

}
