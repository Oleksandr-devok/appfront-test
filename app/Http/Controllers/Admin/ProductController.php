<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\uploadImage;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Jobs\SendPriceChangeNotification;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Traits\GetExchangeRate;
use App\Repositories\ProductRepositoryInterface;

class ProductController extends Controller
{
    use uploadImage, GetExchangeRate;

    protected $productService;
    protected $productRepository;

    public function __construct(ProductService $productService, ProductRepositoryInterface $productRepository)
    {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }
   
    public function index()
    {
        
        $products = $this->productRepository->allProducts();
        return view('admin.products', [
            'products' => $products
        ]);
        
    }

    public function create()
    {
        return view('admin.add_product');
    }

  
    public function store(ProductRequest $request)
    {
      
        $this->productService->createProduct(
            $request->validated(),
            $request->file('image')
        );
        return redirect()->route('admin.products')->with('success', 'Product added successfully');
    }

  
    public function edit(Product $product)
    {
        return view('admin.edit_product', compact('product')); // keep this
    }

    public function update(Product $product, ProductRequest $request)
    {

        $this->productService->updateProduct(
            $product,
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

    public function show(Product $product)
    {
        $exchangeRate = $this->getExchangeRate();
        return view('products.show', compact('product', 'exchangeRate'));
    }
   
    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);
        //delete image
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }
}
