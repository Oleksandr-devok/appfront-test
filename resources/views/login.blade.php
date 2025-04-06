@extends('./layouts.main')
@section('content')
@section('title', 'Login')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush
<div class="login-container">
    <h1>Admin Login</h1>

    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control"
                value="  {{ app()->environment('local') ? 'test@example.com' : '' }}" required>

            @error('email')
                <strong style="color: red; font-size: 10px;">{{ $message }}</strong>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control"
                value="{{ app()->environment('local') ? 'password' : '' }}" required>
            @error('password')
                <strong style="color: red; font-size: 10px;">{{ $message }}</strong>
            @enderror
        </div>

        <button type="submit" class="btn-login">Login</button>
    </form>
</div>
@endsection
