<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/result/{sale}', [SaleController::class, 'result'])->name('sales.result');

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
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
