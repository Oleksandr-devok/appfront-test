@extends('../layouts.main')
@section('content')
@section('title', 'Edit Product')
@push('styles')
        <link rel="stylesheet" href="{{ asset('css/edit-product.css') }}">
    @endpush
    <div class="admin-container">
        <h1>Edit Product</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="error-text">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.update.product', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <strong style="color: red; font-size: 10px;">{{ $message }}</strong>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <strong style="color: red; font-size: 10px;">{{ $message }}</strong>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" class="form-control"
                    value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <strong style="color: red; font-size: 10px;">{{ $message }}</strong>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Current Image</label>
                @if ($product->image)
                    <img src="{{ asset('storage/products/' . $product->image) }}" class="product-image"
                        alt="{{ $product->name }}">
                @endif
                <input type="file" id="image" name="image" class="form-control">
                <small>Leave empty to keep current image</small>
                @error('image')
                    <strong style="color: red; font-size: 10px;">{{ $message }}</strong>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
