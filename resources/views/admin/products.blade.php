@extends('../layouts.main')
@section('content')
@section('title', 'All Products')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    @endpush
    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin - Products</h1>
            <div>
                <a href="{{ route('admin.add.product') }}" class="btn btn-primary">Add New Product</a>
                <a onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                    href="{{ route('logout') }}" class="btn btn-secondary">Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif



        <table class="admin-table table-responsive" id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            @forelse ($products as $product)
                <tbody>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>
                            @if ($product->image)
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalLong-{{ $product->id }}">
                                    View Product
                                </button>
                            @endif
                        </td>
                        <div class="modal fade" id="exampleModalLong-{{ $product->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                            {{ $product->name }}
                                        </h5>
                                        <button type="button" class="close btn btn-primary" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ asset('storage/products/' . $product->image) }}"
                                            style="max-width: 100%; height: auto;" alt="{{ $product->image }}">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"
                                            data-bs-dismiss="modal">Close</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <td>{{ Str::limit($product->description, 20, '...') }}</td>

                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            <a href="{{ route('admin.edit.product', $product) }}" class="btn btn-primary">Edit</a>
                            <a onclick="
                            event.preventDefault();
                            if(confirm('Are you sure you want to delete this product?')){
                                document.getElementById('{{ 'form-delete-' . $product->id }}').submit();
                            }"
                                href="{{ route('admin.delete.product', $product) }}" class="btn btn-secondary">Delete
                            </a>

                            <form action="{{ route('admin.delete.product', $product) }}" method="POST" class="d-none"
                                id="{{ 'form-delete-' . $product->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                </tbody>
            @empty
                <p class="bold text-center mt-3"><b>No Products Available at the moment</b></p>
            @endforelse
        </table>
        <div class=" d-flex justify-content-center mt-4">
            <div class="">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
