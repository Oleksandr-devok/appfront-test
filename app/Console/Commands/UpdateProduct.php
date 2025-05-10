<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use Illuminate\Console\Command;

class UpdateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:update {id} {--name=} {--description=} {--price=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a product with the specified details';

    protected $productService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');

        $data = [];
        if ($this->option('name')) {
            $data['name'] = $this->option('name');
        }

        if ($this->option('description')) {
            $data['description'] = $this->option('description');
        }

        if ($this->option('price')) {
            $data['price'] = $this->option('price');
        }

        try {
            $this->productService->updateProductUsingCommand($id, $data);
            $this->info('Product updated successfully.');
        } catch (\Exception $e) {
            $this->error('Error: '.$e->getMessage());
        }
    }
}
