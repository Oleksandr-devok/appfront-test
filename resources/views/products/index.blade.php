<x-layouts.guest>
    <h1>Products</h1>

        <div class="products-grid">
            @forelse ($products as $product)
                <x-partials.products.card :product="$product" :exchangeRate="$exchangeRate" />
            @empty
                <div class="empty-message">
                    <p>No products found.</p>
                </div>
            @endforelse
        </div>

        <div style="margin-top: 20px; text-align: center; font-size: 0.9rem; color: #7f8c8d;">
            <p>Exchange Rate: 1 USD = {{ number_format($exchangeRate, 4) }} EUR</p>
        </div>
</x-layouts.guest>
