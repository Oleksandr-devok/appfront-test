<?php

namespace App\Services;

use App\Http\Traits\uploadImage;
use App\Jobs\SendPriceChangeNotification;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\Log;

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
            $data['image'] = $imageName;
            $product = $this->productRepository->create($data);

            return $product;
        } else {
            $data['image'] = 'product-placeholder.png';
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
            $this->sendPriceChangeNotification($product, $oldPrice);
        }

        return $updated;
    }

    public function updateProductUsingCommand($id, array $data)
    {
        $this->validateProductData($data);

        $product = Product::find($id);

        if (! $product) {
            throw new \Exception('Product not found');
        }
        $oldPrice = $product->price;

        $product->update($data);

        if (isset($data['price']) && $oldPrice != $product->price) {
            $this->sendPriceChangeNotification($product, $oldPrice);
        }

        return true;
    }

    public function deleteProduct(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }

    protected function validateProductData(array $data)
    {
        if (isset($data['name'])) {
            if (empty($data['name']) || trim($data['name']) == '') {
                throw new \Exception('Name cannot be empty.');
            }

            if (strlen($data['name']) < 3) {
                throw new \Exception('Name must be at least 3 characters long.');
            }
        }

        if (isset($data['price']) && ! is_numeric($data['price'])) {
            throw new \Exception('Price must be a valid number.');
        }
    }

    protected function sendPriceChangeNotification($product, $oldPrice)
    {
        try {
            $notificationEmail = env('PRICE_NOTIFICATION_EMAIL', 'admin@example.com');

            SendPriceChangeNotification::dispatch(
                $product,
                $oldPrice,
                $product->price,
                $notificationEmail
            );
        } catch (\Exception $e) {
            Log::error('Failed to dispatch price change notification: '.$e->getMessage());
        }
    }
}
