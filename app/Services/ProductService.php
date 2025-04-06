<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\uploadImage;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendPriceChangeNotification;
use App\Repositories\ProductRepositoryInterface;

class ProductService
{

    use uploadImage;
    protected $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function createProduct(array $data, $image = null): Product
    {
   
        if ($image) {
            $imageName = $this->uploadImage($image, 'products');
            $data["image"] =  $imageName;
            $product = $this->productRepository->create($data);
            return $product;
        } else {
            $data["image"] =  'product-placeholder.png';
            $product = $this->productRepository->create($data);
            return $product;
        }
    }

    public function updateProduct(Product $product, array $data, $image = null): bool
    {
        $oldPrice = $product->price;
      
        if ($image) {
            $imageName = $this->uploadImage($image, 'products');
            $data['image'] = $imageName;
        }
       
        $updated = $this->productRepository->update($product, $data);

        if ($oldPrice != $product->price) {
            try {
                SendPriceChangeNotification::dispatch(
                    $product,
                    $oldPrice,
                    $product->price,
                    env('PRICE_NOTIFICATION_EMAIL', 'admin@example.com')
                );
            } catch (\Exception $e) {
                Log::error('Failed to dispatch price change notification: '.$e->getMessage());
            }
        }
        return $updated;
    }

    public function deleteProduct(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }
}
