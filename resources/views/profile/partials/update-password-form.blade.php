<section>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0">{{ __('Update Password') }}</h6>
    </div>
    <p class="text-muted mb-4">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
            <input type="password" class="form-control" id="update_password_current_password" name="current_password" autocomplete="current-password">
            @error('current_password', 'updatePassword') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
            <input type="password" class="form-control" id="update_password_password" name="password" autocomplete="new-password">
            @error('password', 'updatePassword') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <span class="text-success small fade show" id="password-status">
                    <i class="fa fa-check-circle me-1"></i> {{ __('Saved.') }}
                </span>
                <script>
                    setTimeout(() => {
                        const status = document.getElementById('password-status');
                        if(status) status.classList.add('d-none');
                    }, 3000);
                </script>
            @endif
        </div>
    </form>
</section>
