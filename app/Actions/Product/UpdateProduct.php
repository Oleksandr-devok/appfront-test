<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use App\DTOs\Product\ProductData;

class UpdateProduct
{
    public function execute(Product $product, ProductData $data): Product
    {
        $data = $data->toArray();

        if($data['is_updating'] && $data['image'] === 'product-placeholder.jpg') {
            unset($data['image']);
        }
        
        $product->update($data);

        return $product;
    }
}