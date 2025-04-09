<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendPriceChangeNotification;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use App\Actions\Product\CreateProduct;
use App\DTOs\Product\ProductData;
use App\Actions\Product\UpdateProduct;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(ProductRequest $request, CreateProduct $createProduct)
    {
        $createProduct->execute(ProductData::fromRequest($request));

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product added successfully');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product, UpdateProduct $updateProduct)
    {
        $oldPrice = $product->price;
        $updateProduct->execute($product, ProductData::fromRequest($request));

        if ($oldPrice != $product->price) {
            $notificationEmail = config('app.price_notification_email');
            try {
                SendPriceChangeNotification::dispatch(
                    $product,
                    $oldPrice,
                    $product->price,
                    $notificationEmail
                );
            } catch (\Exception $e) {
                 Log::error('Failed to dispatch price change notification: ' . $e->getMessage());
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
}
