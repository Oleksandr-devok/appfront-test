@extends('layouts.main')
@section('content')
@section('title', '403')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush
<div class="login-container">
    <h2 class="text-center">Forbidden</h2>
</div>
@endsection
