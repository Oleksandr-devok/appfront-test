<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController as ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', [ProductController::class, 'index']);

Route::get('/products/{product_id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::middleware(['auth'])->group(function () {
    Route::resource('admin/products', AdminProductController::class)->names([
        'index' => 'admin.products',
        'create' => 'admin.add.product',
        'store' => 'admin.add.product.submit',
        'show' => 'admin.products.show',
        'edit' => 'admin.edit.product',
        'update' => 'admin.update.product',
        'destroy' => 'admin.delete.product',
    ]);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
