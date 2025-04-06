@extends('layouts.main')
@section('content')
@section('title', 'Products List')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/product-list.css') }}">
    @endpush
    <div class="container">
        <h1>Products</h1>

        <div class="products-grid">
            @forelse ($products as $product)
                <div class="product-card">
                    @if ($product->image)
                        <img src="{{ asset('storage/products/' . $product->image) }}" class="product-image"
                            alt="{{ $product->name }}">
                    @endif
                    <div class="product-info">
                        <h2 class="product-title">{{ $product->name }}</h2>
                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                        <div class="price-container">
                            <span class="price-usd">${{ number_format($product->price, 2) }}</span>
                            <span class="price-eur">€{{ number_format($product->price * $exchangeRate, 2) }}</span>
                        </div>
                        <a href="{{ route('products.view', $product->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            @empty
                <div class="empty-message">
                    <p>No products found.</p>
                </div>
            @endforelse
        </div>
        <div class=" d-flex justify-content-center mt-4">
            <div class="">
                {{ $products->links() }}
            </div>
        </div>

        <div style="margin-top: 20px; text-align: center; font-size: 0.9rem; color: #7f8c8d;">
            <p>Exchange Rate: 1 USD = {{ number_format($exchangeRate, 4) }} EUR</p>
        </div>
    </div>
@endsection
