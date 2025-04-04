<?php

namespace App\Http\Controllers;

use App\Jobs\SendPriceChangeNotification;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // public function loginPage()
    // {
    //     return view('login');
    // }

    // public function login(Request $request)
    // {

    //     if (Auth::attempt($request->except('_token'))) {
    //         return redirect()->route('admin.products');
    //     }

    //     return redirect()->back()->with('error', 'Invalid login credentials');
    // }

    // public function logout()
    // {
    //     Auth::logout();

    //     return redirect()->route('login');
    // }

    public function products()
    {
        $products = Product::all(); // paginate this

        return view('admin.products', compact('products'));
    }

    public function editProduct($id)
    {
        // use route model binding
        $product = Product::find($id); // find or fail(no need)

        return view('admin.edit_product', compact('product')); // keep this
    }

    public function updateProduct(Request $request, $id)
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

        $product = Product::find($id);

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

    public function deleteProduct($id)
    {
        // use route model binding
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }

    public function addProductForm()
    {
        return view('admin.add_product');
    }

    public function addProduct(Request $request)
    {

        // validate other parameters and use form requests
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // use trait for image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $product->image = 'uploads/'.$filename;
        } else {
            $product->image = 'product-placeholder.jpg';
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product added successfully');
    }
}
