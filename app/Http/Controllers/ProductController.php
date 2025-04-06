<?php

namespace App\Http\Controllers;

use App\Http\Traits\GetExchangeRate;
use App\Models\Product;

class ProductController extends Controller
{
    use GetExchangeRate;

    public function index()
    {
        $products = Product::latest()->paginate(5);
        $exchangeRate = $this->getExchangeRate();

        return view('products.list', compact('products', 'exchangeRate'));
    }
}
