@extends('layouts.main')
@section('content')
@section('title', '500')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush
<div class="login-container">
    <h2 class="text-center">Oops something went wrong</h2>
</div>
@endsection
