<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $exchangeRate = $this->getExchangeRate();

        return view('products.list', [
            'products' => $products,
            'exchangeRate' => number_format($exchangeRate, 4)
        ]);
    }

    public function show(Request $request)
    {
        $product = Product::findOrFail($request->route('product_id'));
        $exchangeRate = $this->getExchangeRate();

        return view('products.show', [
            'product' => $product,
            'exchangeRate' => number_format($exchangeRate, 4)
        ]);
    }

    /**
     * Retrieve the current USD to EUR exchange rate.
     *
     * @return float
     */
    private function getExchangeRate(): float
    {
        try {
            $response = Http::timeout(5)->get('https://open.er-api.com/v6/latest/USD');

            if ($response->successful() && isset($response['rates']['EUR'])) {
                return (float) $response['rates']['EUR'];
            }
        } catch (\Exception $e) {
            Log::warning('Exchange rate API failed: ' . $e->getMessage());
        }

        // Default fallback from .env or hardcoded value
        return (float) env('EXCHANGE_RATE', 0.85);
    }
}
