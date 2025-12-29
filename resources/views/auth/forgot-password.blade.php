<x-guest-layout title="Forgot Password">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Forgot Password</h3>
    </div>
    
    <div class="mb-4 text-sm text-muted">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
            <label for="floatingInput">Email address</label>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">{{ __('Email Password Reset Link') }}</button>
        
        <p class="text-center mb-0">Remembered your password? <a href="{{ route('login') }}">Sign In</a></p>
    </form>
</x-guest-layout>
