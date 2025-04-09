<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;

Route::get('/', [ProductController::class, 'index']);

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/products', [AdminProductController::class, 'index'])->name('products');
        Route::get('/products/add', [AdminProductController::class, 'create'])->name('add.product');
        Route::post('/products/add', [AdminProductController::class, 'store'])->name('add.product.submit');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('edit.product');
        Route::post('/products/{product}', [AdminProductController::class, 'update'])->name('update.product');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('delete.product');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });
