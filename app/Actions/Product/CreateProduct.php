<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use App\DTOs\Product\ProductData;

class CreateProduct
{
    public function execute(ProductData $data): Product
    {
        return Product::create($data->toArray());
    }
}