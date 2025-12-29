@extends('layouts.admin')

@section('header', 'My Profile')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
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
