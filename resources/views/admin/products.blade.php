@extends('../layouts.main')
@section('content')
@section('title', 'Products')
    <div class="admin-container-list">
        <div class="admin-header">
            <h1>Admin - Products</h1>
            <div>
                <a href="{{ route('admin.add.product') }}" class="btn btn-primary">Add New Product</a>
                <a href="{{ route('logout') }}" class="btn btn-secondary">Logout</a>
            </div>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        <div class="success-message delete d-none">
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                <td>{{ $loop->index + 1 }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ env('APP_URL') }}/{{ $product->image }}" width="50" height="50" alt="{{ $product->name }}">
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.edit.product', $product->id) }}" class="btn btn-primary">Edit</a>
                        <a href="javascript:void(0);" class="btn btn-danger" onclick="deleteProduct({{ $product->id }})">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch(`/admin/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        const successMessage = document.querySelector('.success-message.delete');
                        successMessage.classList.remove('d-none');
                        successMessage.textContent = "Product deleted successfully";
                        setTimeout(() => {
                            successMessage.classList.add('d-none');
                            window.location.href = "{{ route('admin.products') }}";
                        }, 3000);
                    } else {
                        alert('Failed to delete the product.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong.');
                });
            }
        }
    </script>
@endsection
