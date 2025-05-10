<?php

namespace App\Repositories;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function allProducts($perPage = 20);

    public function create(array $data): Product;

    public function update(Product $product, array $data): bool;

    public function delete(Product $product): bool;

    public function updateProductUsingCommand(Product $product, array $data);
}
