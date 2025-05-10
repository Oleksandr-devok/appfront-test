@extends('../layouts.main')
@section('content')
@section('title', 'Add Products')
    <div class="admin-container">
        <h1>Add New Product</h1>

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

        <!-- Form for Adding New Product -->
        <form action="{{ route('admin.add.product.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required aria-describedby="nameHelp">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <small id="nameHelp" class="form-text text-muted">Enter the product's name</small>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>
                <small id="descriptionHelp" class="form-text text-muted">Provide a brief description of the product</small>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" class="form-control" value="{{ old('price') }}" required aria-describedby="priceHelp">
                <small id="priceHelp" class="form-text text-muted">Enter the product price</small>
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" id="image" name="image" class="form-control" aria-describedby="imageHelp">
                <small id="imageHelp" class="form-text text-muted">Leave empty to use default image</small>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Product</button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
