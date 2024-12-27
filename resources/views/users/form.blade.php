@extends('layouts.dashboard')

@section('title')
    {{ isset($user) ? 'Edit User' : 'Add User' }}
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold">{{ isset($user) ? 'Edit User' : 'Add User' }}</h3>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}">Users</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">
                        {{ isset($user) ? 'Edit User' : 'Add User' }}
                    </a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($user))
                            @method('PUT')
                        @endif

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name ?? '') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role"
                                class="form-select form-control @error('role') is-invalid @enderror" required>
                                <option value="" disabled {{ isset($user) ? '' : 'selected' }}>Select a role
                                </option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ isset($user) && $user->getRoleNames()->first() === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                {{ isset($user) ? '' : 'required' }}>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            @if (isset($user))
                                <small class="text-muted">Leave this field empty if you don't want to change the
                                    password.</small>
                            @endif
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                {{ isset($user) ? '' : 'required' }}>
                            @error('password_confirmation')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($user) ? 'Update User' : 'Create User' }}
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
