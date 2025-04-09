<x-layouts.auth>
    <x-pages.header title="Edit Product" />
    <x-partials.validation-errors />

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="form-group">
            <label for="image">Current Image</label>
            @if($product->image)
                <img src="/{{ $product->image }}" class="product-image" alt="{{ $product->name }}">
            @endif
            <input type="file" id="image" name="image" class="form-control">
            <small>Leave empty to keep current image</small>
        </div>

        <div class="form-group">
            <x-partials.button text="Update Product" type="submit" class="btn btn-primary" />
            <x-partials.button-link text="Cancel" route="{{ route('admin.products.index') }}" class="btn btn-secondary" />
        </div>
    </form>
</x-layouts.auth>