<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

require base_path('routes/auth.php'); 

Route::get('/', [ProductController::class, 'index']);
Route::get('/products/{product_id}', [ProductController::class, 'show'])->name('products.view');


Route::middleware(['auth'])->prefix('admin')->group(function () {
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
