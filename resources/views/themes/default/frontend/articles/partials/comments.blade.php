<div class="blog-comment-area pd-bottom-50" id="comments">
    <div class="section-title">
        <h6 class="title">
            {{ $article->comments->count() + $article->comments->sum(fn($c) => $c->children->count()) }}
            {{ __('frontend.comments') }}
        </h6>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ __('frontend.comment_success') }}
        </div>
    @endif

    {{-- ================= COMMENTS LIST ================= --}}
    @foreach($article->comments as $comment)
        <div class="media mb-4">
            <div class="media-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">
                        {{ $comment->name }}
                        <span class="date text-muted" style="font-size:12px;">
                            {{ $comment->created_at->translatedFormat('d M Y') }}
                        </span>
                    </h6>
                    <button
                        class="btn btn-sm btn-outline-primary py-0 px-2"
                        onclick="replyTo('{{ $comment->id }}','{{ $comment->name }}')">
                        {{ __('frontend.reply') }}
                    </button>
                </div>

                <p>{{ $comment->body }}</p>

                {{-- ===== CHILD COMMENTS ===== --}}
                @foreach($comment->children as $child)
                    <div class="media mt-4 pl-4 border-left">
                        <div class="media-body">
                            <h6 class="mb-1">
                                {{ $child->name }}
                                <span class="date text-muted" style="font-size:12px;">
                                    {{ $child->created_at->translatedFormat('d M Y') }}
                                </span>
                            </h6>
                            <p class="mb-0">{{ $child->body }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
    @endforeach

    {{-- ================= COMMENT FORM ================= --}}
    <div class="comment-form-area mt-5" id="reply-form">
        <div class="section-title d-flex justify-content-between align-items-center">
            <h6 class="title" id="form-title">
                {{ __('frontend.leave_comment') }}
            </h6>
            <button id="cancel-reply"
                    class="btn btn-sm btn-danger d-none"
                    onclick="cancelReply()">
                Cancel Reply
            </button>
        </div>

        <form action="{{ route('article.comment', $article->slug) }}"
              method="POST"
              class="comment-form">
            @csrf

            {{-- Honeypot --}}
            <div style="display:none;">
                <input type="text" name="website_catch" tabindex="-1" autocomplete="off">
            </div>

            <input type="hidden" name="parent_id" id="parent_id_input">

            <div class="row">
                <div class="col-md-6">
                    <div class="single-input-wrap mb-3">
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="{{ __('frontend.name') }}"
                               value="{{ auth()->user()->name ?? old('name') }}"
                               required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="single-input-wrap mb-3">
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="{{ __('frontend.email') }}"
                               value="{{ auth()->user()->email ?? old('email') }}"
                               required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="single-input-wrap mb-3">
                        <textarea name="body"
                                  class="form-control"
                                  rows="4"
                                  placeholder="{{ __('frontend.message_placeholder') }}"
                                  required>{{ old('body') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Google reCAPTCHA v3 --}}
            <input type="hidden" name="g-recaptcha-response" id="recaptcha-token">

            @error('g-recaptcha-response')
                <small class="text-danger d-block mb-2">
                    {{ $message }}
                </small>
            @enderror

            <button type="submit" class="btn btn-blue">
                {{ __('frontend.post_comment') }}
            </button>
            
            <small class="d-block mt-2 text-muted" style="font-size: 11px;">
                This site is protected by reCAPTCHA and the Google 
                <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and 
                <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.
            </small>
        </form>
    </div>
</div>

<style>
    .grecaptcha-badge { visibility: hidden; }
</style>

{{-- ================= RECAPTCHA SCRIPT ================= --}}
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.comment-form');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        grecaptcha.ready(function () {
            grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
                action: 'comment'
            }).then(function (token) {
                document.getElementById('recaptcha-token').value = token;
                form.submit();
            });
        });
    });
});
</script>

{{-- ================= REPLY SCRIPT ================= --}}
<script>
function replyTo(id, name) {
    document.getElementById('parent_id_input').value = id;
    document.getElementById('form-title').innerText = 'Replying to ' + name;
    document.getElementById('cancel-reply').classList.remove('d-none');
    document.getElementById('reply-form').scrollIntoView({ behavior: 'smooth' });
}

function cancelReply() {
    document.getElementById('parent_id_input').value = '';
    document.getElementById('form-title').innerText = '{{ __('frontend.leave_comment') }}';
    document.getElementById('cancel-reply').classList.add('d-none');
}
</script>
