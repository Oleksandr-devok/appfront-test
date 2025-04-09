<?php

declare(strict_types=1);

namespace App\DTOs\Product;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
class ProductData
{
    public function __construct(
        public string $name,
        public ?string $description,
        public float $price,
        public ?UploadedFile $image,
        public bool $isUpdating = true
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            description: $request->input('description'),
            price: $request->float('price'),
            image: $request->file('image')
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image
                ? $this->image->store('', 'public')
                :  'product-placeholder.jpg',
            'is_updating' => $this->isUpdating,
        ];
    }
}
