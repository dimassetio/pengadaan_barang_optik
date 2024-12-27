<div class="card">
    <div class="card-header">
        <div class="card-title">Update Profile Information</div>
    </div>
    <div class="card-body">
        <!-- Email Verification Form -->
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <!-- Profile Update Form -->
        <form id="update-profile" method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <!-- Name Field -->
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input id="name" name="name" type="text" class="form-control"
                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" class="form-control"
                    value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <!-- Email Verification -->
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-muted">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification"
                                class="btn btn-link p-0">{{ __('Click here to re-send the verification email.') }}</button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="text-success mt-2">
                                {{ __('A new verification link has been sent to your email address.') }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </form>
    </div>
    <div class="card-action">
        <!-- Save Button -->
        <button type="submit" form="update-profile" class="btn btn-success">{{ __('Save') }}</button>

        <!-- Cancel Button -->
        <button type="button" class="btn btn-danger" onclick="window.history.back();">{{ __('Cancel') }}</button>
    </div>

    <!-- Success Message -->
    @if (session('status') === 'profile-updated')
        <script>
            console.log("STATUS UPDATED");
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ __('Profile updated successfully.') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif
</div>
