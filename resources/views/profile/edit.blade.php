@extends('layouts.admin')

@section('header', 'My Profile')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i> {{ session('status') === 'password-updated' ? __('Password updated successfully.') : __('Profile updated successfully.') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <!-- Left Column: Profile Info & Password -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded p-4 mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-secondary rounded p-4">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Right Column: Delete Account (Optional/Danger Zone) -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded p-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
