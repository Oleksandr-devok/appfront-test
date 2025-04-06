<?php

namespace App\Repositories;


use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function allProducts($perPage = 20)
    {
        return Product::latest()->paginate($perPage);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    public function updateProductUsingCommand(Product $product, array $data)
    {
       
        $product->update($data);
        $product->save();

        return $product;
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

}
