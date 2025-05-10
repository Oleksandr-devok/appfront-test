@extends('../layouts.main')
@section('content')
@section('title', 'Edit Products')
    <div class="admin-container">
        <h1>Edit Product</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form to Edit Product -->
        <form action="{{ route('admin.update.product', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required aria-describedby="nameHelp">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <small id="nameHelp" class="form-text text-muted">Enter the product's name.</small>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" required aria-describedby="descriptionHelp">{{ old('description', $product->description) }}</textarea>
                <small id="descriptionHelp" class="form-text text-muted">Provide a detailed description of the product.</small>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" class="form-control" value="{{ old('price', $product->price) }}" required aria-describedby="priceHelp">
                <small id="priceHelp" class="form-text text-muted">Enter the product price.</small>
            </div>

            <div class="form-group">
                <label for="image">Current Image</label>
                @if($product->image)
                    <div>
                        <img src="{{ env('APP_URL') }}/{{ $product->image }}" class="product-image" alt="{{ $product->name }}">
                        <p>Current Image</p>
                    </div>
                @else
                    <p>No image available</p>
                @endif
                <input type="file" id="image" name="image" class="form-control" aria-describedby="imageHelp">
                <small id="imageHelp" class="form-text text-muted">Leave empty to retain the current image.</small>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
