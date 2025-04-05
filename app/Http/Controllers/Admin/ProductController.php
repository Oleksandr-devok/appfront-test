<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\uploadImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Jobs\SendPriceChangeNotification;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use uploadImage;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
        $products = Product::latest()->paginate(20);
        return view('admin.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add_product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // // validate other parameters and use form requests
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|min:3',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()
        //         ->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }


        $product = Product::create( $request->validated());

        // use trait for image upload
        if ($request->hasFile('image')) {
            // $file = $request->file('image');
            // $filename = $file->getClientOriginalExtension();
            // $file->move(public_path('uploads'), $filename);
            // $product->image = 'uploads/' . $filename;
            $imageNameToStore = $this->uploadImage($request->file('image'), 'products');
            
            $product->image =  $imageNameToStore;
            $product->save();
        } else {
            $product->image = 'product-placeholder.jpg';
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
      // use route model binding
    //   $product = Product::find($id); // find or fail(no need)

      return view('admin.edit_product', compact('product')); // keep this
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, Request $request)
    {
         // create a product service
        // use route model binding
        // Validate the name field
        // use form request for validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]); // why validate only name (Validate others including image)

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } // there will be no need

        // $product = Product::find($id);

        // Store the old price before updating
        $oldPrice = $product->price;

        // why hit the database twice
        $product->update($request->all());

        // move out this upload (i will have an upload image trait)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $product->image = 'uploads/'.$filename;
        }

        $product->save();

        // Check if price has changed
        if ($oldPrice != $product->price) {
            // Get notification email from env
            $notificationEmail = env('PRICE_NOTIFICATION_EMAIL', 'admin@example.com');

            try {
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

        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
      // use route model binding
    //   $product = Product::find($id);
      $product->delete();

      return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }
}
