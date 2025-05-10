@extends('layouts.main')
@section('content')
@section('title', '404')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush
<div class="login-container">
    <h2 class="text-center">Page not found</h2>
</div>
@endsection
