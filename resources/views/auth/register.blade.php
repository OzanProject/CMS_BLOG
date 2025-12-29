<x-guest-layout title="Sign Up">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Sign Up</h3>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingText" name="name" value="{{ old('name') }}" placeholder="jhondoe" required autofocus>
            <label for="floatingText">Username</label>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
            <label for="floatingInput">Email address</label>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-floating mb-4">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-floating mb-4">
            <input type="password" class="form-control" id="floatingPasswordConfirm" name="password_confirmation" placeholder="Confirm Password" required>
            <label for="floatingPasswordConfirm">Confirm Password</label>
            @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                <label class="form-check-label" for="exampleCheck1">I agree with terms</label>
            </div>
            <a href="{{ route('login') }}">Already have an account?</a>
        </div>
        
        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
        
        <p class="text-center mb-0">Already have an Account? <a href="{{ route('login') }}">Sign In</a></p>
    </form>
</x-guest-layout>
