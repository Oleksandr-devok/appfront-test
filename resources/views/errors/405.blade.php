@extends('layouts.main')
@section('content')
@section('title', '405')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush
<div class="login-container">
    <h2 class="text-center">Not allowed</h2>
</div>
@endsection
