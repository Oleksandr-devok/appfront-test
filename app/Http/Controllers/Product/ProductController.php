<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Traits\GetExchangeRate;
use App\Models\Product;

class ProductController extends Controller
{
    use GetExchangeRate;

    public function index()
    {
        $products = Product::latest()->paginate(20);
        $exchangeRate = $this->getExchangeRate();

        return view('products.list', compact('products', 'exchangeRate'));
    }

    public function show($id)
    {

        $product = Product::findOrFail($id);
        $exchangeRate = $this->getExchangeRate();

        return view('products.show', [
            'product' => $product,
            'exchangeRate' => $exchangeRate,
        ]);
    }
}
