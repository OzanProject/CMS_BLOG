<section>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0">{{ __('Profile Information') }}</h6>
    </div>
    <p class="text-muted mb-4">
        {{ __("Update your account's profile information and email address.") }}
    </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="photo" class="form-label">{{ __('Profile Photo') }}</label>
            <div class="d-flex align-items-center gap-3">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                @else
                    <div class="rounded-circle bg-dark d-flex align-items-center justify-content-center text-white" style="width: 60px; height: 60px;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
            </div>
            @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted small">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0 small align-baseline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success small fw-bold">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small fade show" id="profile-status">
                    <i class="fa fa-check-circle me-1"></i> {{ __('Saved.') }}
                </span>
                <script>
                    setTimeout(() => {
                        const status = document.getElementById('profile-status');
                        if(status) status.classList.add('d-none');
                    }, 3000);
                </script>
            @endif
        </div>
    </form>
</section>
