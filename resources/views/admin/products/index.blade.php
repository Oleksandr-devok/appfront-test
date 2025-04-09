<x-layouts.auth>
    <x-pages.header title="Products" style="justify-content: space-between;">
        <div>
            <x-partials.button-link text="Add New Product" route="{{ route('admin.products.create') }}" />
            <x-partials.button-link text="Logout" route="{{ route('admin.logout') }}" class="btn btn-secondary" />
        </div>
    </x-pages.header>

    <x-partials.alert-success />

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ env('APP_URL') }}/{{ $product->image }}" width="50" height="50" alt="{{ $product->name }}">
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>
                    <x-partials.button-link text="Edit" route="{{ route('admin.products.edit', $product->id) }}" />
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <x-partials.button text="Delete" type="submit" onclick="return confirm('Are you sure you want to delete this product?')" />
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @push('styles')
        <style>
            .admin-container {
                max-width: none;
            }
        </style>
    @endpush
</x-layouts.auth>