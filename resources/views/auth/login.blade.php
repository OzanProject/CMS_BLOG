<x-guest-layout title="Sign In">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Sign In</h3>
    </div>
    
    <!-- Session Status -->
    @if(session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
            <label for="floatingInput">Email address</label>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        
        <div class="form-floating mb-4">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot Password</a>
            @endif
        </div>
        
        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
        
        <p class="text-center mb-0">Don't have an Account? <a href="{{ route('register') }}">Sign Up</a></p>
    </form>
</x-guest-layout>
