<div class="widget widget_newsletter">
    <h5 class="widget-title border-bottom pb-3 mb-3">{{ __('frontend.newsletter') ?? 'Newsletter' }}</h5>
    <div class="newsletter-content bg-light p-4 rounded text-center">
        <i class="fa fa-envelope-open-o fa-3x text-primary mb-3"></i>
        
        @if(session('success'))
            <div class="alert alert-success p-2 mb-3" style="font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger p-2 mb-3" style="font-size: 14px;">
                {{ $errors->first() }}
            </div>
        @endif

        <p class="mb-3">{{ __('frontend.newsletter_desc') ?? 'Subscribe to get the latest updates.' }}</p>
        <form action="{{ route('newsletter.subscribe') }}" method="POST">
            @csrf
            <div class="form-group mb-2">
                <input type="email" name="email" class="form-control text-center" placeholder="{{ __('frontend.email') }}" required>
            </div>
            <button class="btn btn-primary w-100" type="submit">{{ __('frontend.subscribe') ?? 'Subscribe' }}</button>
        </form>
    </div>
</div>
