<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

require base_path('routes/auth.php'); // look for a modern way to import this

Route::get('/', [ProductController::class, 'index']);

Route::get('/products/{product_id}', [ProductController::class, 'show'])->name('products.show');

// Route::get('/login', [AdminController::class, 'loginPage'])->name('login');
// Route::post('/login', [AdminController::class, 'login'])->name('login.submit');

// add role based access control (only admin can see this)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    // Route::get('/admin/products/add', [AdminController::class, 'addProductForm'])->name('admin.add.product');
    // Route::post('/admin/products/add', [AdminController::class, 'addProduct'])->name('admin.add.product.submit');
    // Route::get('/admin/products/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.edit.product');
    // Route::post('/admin/products/edit/{id}', [AdminController::class, 'updateProduct'])->name('admin.update.product');
    // Route::get('/admin/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.delete.product');
    // Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::resource('products', AdminProductController::class)->names([
        'index' => 'admin.products',
        'create' => 'admin.add.product',
        'edit' => 'admin.edit.product',
        'update' => 'admin.update.product',
        'destroy' => 'admin.delete.product',
        'store' => 'admin.store.product',
    ])->missing(function (Request $request) {
        return Redirect::route('admin.products');
    });
});
