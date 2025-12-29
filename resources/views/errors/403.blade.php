@extends('layouts.admin')

@section('header', 'Access Denied')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row vh-100 bg-secondary rounded align-items-center justify-content-center mx-0">
        <div class="col-md-6 text-center">
            <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
            <h1 class="display-1 fw-bold">403</h1>
            <h1 class="mb-4">Access Denied</h1>
            <p class="mb-4">We’re sorry, but you do not have permission to access this page. Please contact your administrator if you believe this is a mistake.</p>
            <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('dashboard') }}">Go Back To Dashboard</a>
        </div>
    </div>
</div>
@endsection
