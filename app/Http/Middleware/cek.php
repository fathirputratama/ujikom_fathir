<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
   
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/export', [SaleController::class, 'export'])->name('sales.export');
    Route::get('/sales/result/{sale}', [SaleController::class, 'result'])->name('sales.result');
    Route::get('/sales/{id}/pdf', [SaleController::class, 'downloadPdf'])->name('sales.pdf');
   
    Route::middleware(['role:kasir'])->group(function () {
        Route::post('/sales/store', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/sales/checkout', [SaleController::class, 'checkout'])->name('sales.checkout');
        Route::get('/sales/member', [SaleController::class, 'member'])->name('sales.member');
    });
   
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('products', ProductController::class)->except(['index', 'show']);
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function export()
    {
        return Excel::download(new ProductsExport, 'daftar-produk.xlsx');
    }
}





public function downloadPDF($id)
{
    $sale = Sale::with(['saleDetails.product', 'member'])->findOrFail($id);
    $pdf = Pdf::loadView('sales.invoice', compact('sale'));
    return $pdf->download('sale' . $sale->id . '.pdf');
}



<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Email',
            'Role',
            'Tanggal Dibuat',
        ];
    }

    public function map($user): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $user->name,
            $user->email,
            ucfirst($user->role),
            $user->created_at->format('d-m-Y H:i'),
        ];
    }
}
