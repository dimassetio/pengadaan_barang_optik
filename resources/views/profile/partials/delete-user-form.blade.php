<div class="card">
    <div class="card-header">
        <div class="card-title">{{ __('Delete Account') }}</div>
    </div>
    <div class="card-body">
        <p>
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>

        <!-- Delete Account Button -->
        <button class="btn btn-danger" onclick="openDeleteModal()">
            {{ __('Delete Account') }}
        </button>
    </div>

    <!-- Success Message -->
    @if (session('status') === 'account-deleted')
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ __('Account deleted successfully.') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif
</div>

<script>
    function openDeleteModal() {
        Swal.fire({
            title: '{{ __('Confirm Account Deletion') }}',
            html: `
                <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>
                <form id="delete-account" method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="mb-3">
                        <label for="delete_account_password" class="form-label">{{ __('Password') }}</label>
                        <input id="delete_account_password" name="password" type="password" class="form-control" placeholder="{{ __('Password') }}">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: '{{ __('Delete Account') }}',
            cancelButtonText: '{{ __('Cancel') }}',
            focusConfirm: false,
            preConfirm: () => {
                document.getElementById('delete-account').submit();
            }
        });
    }
</script>
