@extends('layouts.app')

@section('content')
  <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
      <h2 class="text-center mb-4">Login</h2>
      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email"
            required>
        </div>
        <div class="mb-3 position-relative">
          <label for="password" class="form-label">Password</label>
          <div class="input-icon">
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password"
              required><span class="input-icon-addon">
              <button type="button" class="btn" id="togglePassword" tabindex="-1">
                <i class="fas fa-eye" id="toggleIcon"></i>
              </button>
            </span>
          </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const togglePasswordButton = document.getElementById('togglePassword');
      const passwordField = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');

      togglePasswordButton.addEventListener('click', () => {
        const isPasswordVisible = passwordField.type === 'text';
        passwordField.type = isPasswordVisible ? 'password' : 'text';
        toggleIcon.classList.toggle('fa-eye', isPasswordVisible);
        toggleIcon.classList.toggle('fa-eye-slash', !isPasswordVisible);
      });
    });
  </script>
@endsection
