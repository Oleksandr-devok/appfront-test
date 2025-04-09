<x-layouts.guest>
        <div class="product-detail">
            <div>
                @if ($product->image)
                    <img src="/{{ $product->image }}" class="product-detail-image">
                @endif
            </div>
            <div class="product-detail-info">
                <h1 class="product-detail-title">{{ $product->name }}</h1>
                <p class="product-id">Product ID: {{ $product->id }}</p>

                <div class="price-container">
                    <span class="price-usd">${{ number_format($product->price, 2) }}</span>
                    <span class="price-eur">€{{ number_format($product->price * $exchangeRate, 2) }}</span>
                </div>

                <div class="divider"></div>

                <div class="product-detail-description">
                    <h4 class="description-title">Description</h4>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="action-buttons">
                    <x-partials.button-link text="Back to Products" route="{{ url('/') }}" class="btn btn-secondary" />
                    <x-partials.button text="Add to Cart" class="btn btn-primary" />
                </div>

                <p style="margin-top: 20px; font-size: 0.9rem; color: #7f8c8d;">
                    Exchange Rate: 1 USD = {{ number_format($exchangeRate, 4) }} EUR
                </p>
            </div>
        </div>
</x-layouts.guest>
