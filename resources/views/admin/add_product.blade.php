@extends('../layouts.main')
@section('content')
@section('title', 'Add Products')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/add-product.css') }}">
    @endpush
    <div class="admin-container">
        <h1>Add New Product</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.store.product') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
                    required>
                @error('name')
                    <strong style="color: red; font-size: 10px;">{{ $message }}</strong>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>
                @error('description')
                    <strong style="color: red; font-size: 10px;">{{ $message }}</strong>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" class="form-control"
                    value="{{ old('price') }}" required>
                @error('price')
                    <strong style="color: red; font-size: 10px;">{{ $message }}</strong>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" id="image" name="image" class="form-control">
                <small>Leave empty to use default image</small>
                @error('image')
                    <strong style="color: red; font-size: 10px;">{{ $message }}</strong>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Product</button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
