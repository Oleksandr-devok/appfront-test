<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowProductRequest;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ExchangeRateService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $productRepository;
    protected $exchangeRateService;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ExchangeRateService $exchangeRateService
    ) {
        $this->productRepository = $productRepository;
        $this->exchangeRateService = $exchangeRateService;
    }

    public function index(): View
    {
        $products = $this->productRepository->paginate(12);
        $exchangeRate = $this->exchangeRateService->getExchangeRate();

        return view('products.list', compact('products', 'exchangeRate'));
    }

    public function show(ShowProductRequest $request): View
    {
        $product = $this->productRepository->findOrFail($request->product_id);
        $exchangeRate = $this->exchangeRateService->getExchangeRate();

        return view('products.show', compact('product', 'exchangeRate'));
    }
}
