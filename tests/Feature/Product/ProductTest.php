<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_that_product_can_be_created_with_image()
    {
        Storage::fake('public');

        $data = [
            'name' => 'Test Product',
            'description' => 'Some description',
            'price' => 99.99,
        ];

        $image = UploadedFile::fake()->image('product.jpg');

        $service = app(ProductService::class);
        $product = $service->createProduct($data, $image);

        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'image' => $product->image,
        ]);

        Storage::disk('public')->assertExists('products/'.$product->image);
        $lastproductSavedToDb = Product::orderBy('id', 'desc')->first();
        $this->assertEquals($lastproductSavedToDb->name, 'Test Product');
        $this->assertEquals($lastproductSavedToDb->description, 'Some description');
        $this->assertEquals($lastproductSavedToDb->price, 99.99);
    }

    public function test_that_product_can_be_created_without_image()
    {
        $data = [
            'name' => 'Placeholder Product',
            'description' => 'No image provided',
            'price' => 19.99,
        ];

        $service = app(\App\Services\ProductService::class);
        $product = $service->createProduct($data);

        $this->assertEquals('product-placeholder.png', $product->image);
        $this->assertDatabaseHas('products', ['name' => 'Placeholder Product']);
    }

    public function test_that_product_can_be_updated_and_price_change_dispatches_job()
    {
        Bus::fake();

        $product = Product::create([
            'name' => 'Original Name',
            'description' => 'Original description',
            'price' => 100,
            'image' => 'original-image.png',
        ]);

        $data = [
            'price' => 150,
            'name' => 'Updated Name',
        ];

        $service = app(\App\Services\ProductService::class);
        $service->updateProduct($product, $data);

        Bus::assertDispatched(\App\Jobs\SendPriceChangeNotification::class);
        $this->assertEquals('Updated Name', $product->fresh()->name);
        $updatedProduct = Product::find($product->id);
        $this->assertEquals(150, $updatedProduct->price);
    }

    public function test_that_product_update_using_command_validates_data()
    {

        $invalidData = [
            'name' => '',
            'price' => '200',
        ];

        $product = Product::create([
            'name' => 'Old Product Name',
            'price' => 100,
        ]);

        $this->expectException(\Exception::class);

        $productService = app(ProductService::class);

        $productService->updateProductUsingCommand($product->id, $invalidData);
    }

    public function test_that_product_can_be_deleted()
    {
        $product = Product::create([
            'name' => 'Original Name',
            'description' => 'Original description',
            'price' => 100,
            'image' => 'original-image.png',
        ]);

        $service = app(ProductService::class);
        $result = $service->deleteProduct($product);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
