<?php

namespace App\Http\Controllers;

use App\Http\Traits\GetExchangeRate;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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
