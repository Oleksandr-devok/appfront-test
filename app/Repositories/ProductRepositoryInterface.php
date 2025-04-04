<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function all(): Collection;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?Product;
    public function findOrFail(int $id): Product;
    public function create(array $data): Product;
    public function update(Product $product, array $data): bool;
    public function delete(int $id): bool;
}