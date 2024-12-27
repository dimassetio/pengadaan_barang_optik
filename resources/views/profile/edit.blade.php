@extends('layouts.dashboard')

@section('title')
    User Profile
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">My Profile</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('profile.partials.update-profile-information-form')
                @include('profile.partials.update-password-form')
                @include('profile.partials.delete-user-form')

            </div>
        </div>
    </div>
@endsection
