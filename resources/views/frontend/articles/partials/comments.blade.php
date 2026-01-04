<div class="blog-comment-area pd-bottom-50" id="comments">
    <div class="section-title">
        <h6 class="title">{{ $article->comments->count() + $article->comments->sum(fn($c) => $c->children->count()) }} {{ __('frontend.comments') }}</h6>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ __('frontend.comment_success') }}
        </div>
    @endif

    <!-- Comments List -->
    @foreach($article->comments as $comment)
    <div class="media">
        <div class="media-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">{{ $comment->name }} <span class="date text-muted" style="font-size: 12px; font-weight: normal;">{{ $comment->created_at->translatedFormat('d M Y') }}</span></h6>
                <button class="btn btn-sm btn-outline-primary py-0 px-2" onclick="replyTo('{{ $comment->id }}', '{{ $comment->name }}')">{{ __('frontend.reply') }}</button>
            </div>
            <p>{{ $comment->body }}</p>

            <!-- Nested Comments -->
            @foreach($comment->children as $child)
            <div class="media mt-4 pl-4 border-left">
                <div class="media-body">
                    <h6 class="mb-2">{{ $child->name }} <span class="date text-muted" style="font-size: 12px; font-weight: normal;">{{ $child->created_at->translatedFormat('d M Y') }}</span></h6>
                    <p>{{ $child->body }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <hr>
    @endforeach

    <!-- Comment Form -->
    <div class="comment-form-area mt-5" id="reply-form">
        <div class="section-title">
            <h6 class="title" id="form-title">{{ __('frontend.leave_comment') }}</h6>
            <button id="cancel-reply" class="btn btn-sm btn-danger d-none" onclick="cancelReply()">Cancel Reply</button>
        </div>
        <form action="{{ route('article.comment', $article->slug) }}" method="POST" class="comment-form">
            @csrf
            <!-- Honeypot -->
            <div style="display: none;">
                <input type="text" name="website_catch" value="" tabindex="-1" autocomplete="off">
            </div>
            <input type="hidden" name="parent_id" id="parent_id_input">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="single-input-wrap">
                        <input type="text" name="name" class="form-control" placeholder="{{ __('frontend.name') }}" value="{{ auth()->user()->name ?? old('name') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single-input-wrap">
                        <input type="email" name="email" class="form-control" placeholder="{{ __('frontend.email') }}" value="{{ auth()->user()->email ?? old('email') }}" required>
                    </div>
                </div>
                <div class="col-12">
                     <div class="single-input-wrap">
                        <textarea name="body" class="form-control" rows="4" placeholder="{{ __('frontend.message_placeholder') }}" required>{{ old('body') }}</textarea>
                    </div>
                </div>
                </div>
                <!-- Google ReCaptcha -->
                <div class="col-12 mb-3">
                    <div class="alert alert-info py-1">
                        <small>Debug Status: Config Key is <strong>{{ config('services.recaptcha.site_key') ? 'LOADED' : 'NOT FOUND (Check .env)' }}</strong></small>
                    </div>
                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    @error('g-recaptcha-response')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-blue">{{ __('frontend.post_comment') }}</button>
        </form>
    </div>
</div>

<script>
    function replyTo(id, name) {
        document.getElementById('parent_id_input').value = id;
        document.getElementById('form-title').innerText = 'Replying to ' + name;
        document.getElementById('cancel-reply').classList.remove('d-none');
        document.getElementById('reply-form').scrollIntoView({behavior: 'smooth'});
    }

    function cancelReply() {
        document.getElementById('parent_id_input').value = '';
        document.getElementById('form-title').innerText = '{{ __('frontend.leave_comment') }}';
        document.getElementById('cancel-reply').classList.add('d-none');
    }
</script>
