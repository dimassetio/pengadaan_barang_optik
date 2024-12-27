<div class="card">
    <div class="card-header">
        <div class="card-title">{{ __('Update Password') }}</div>
    </div>
    <div class="card-body">
        <form id="update-password" method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <!-- Current Password Field -->
            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                <input id="update_password_current_password" name="current_password" type="password"
                    class="form-control" autocomplete="current-password">
                @error('current_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Password Field -->
            <div class="mb-3">
                <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                <input id="update_password_password" name="password" type="password" class="form-control"
                    autocomplete="new-password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-3">
                <label for="update_password_password_confirmation"
                    class="form-label">{{ __('Confirm Password') }}</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="form-control" autocomplete="new-password">
                @error('password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </form>
    </div>
    <div class="card-action">
        <!-- Save Button -->
        <button type="submit" form="update-password" class="btn btn-success">{{ __('Save') }}</button>

        <!-- Cancel Button -->
        <button type="button" class="btn btn-danger" onclick="window.history.back();">{{ __('Cancel') }}</button>
    </div>

    <!-- Success Message -->
    @if (session('status') === 'password-updated')
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ __('Password updated successfully.') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif
</div>
