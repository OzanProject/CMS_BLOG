@extends('frontend.layouts.frontend')

@section('meta_title', $article->meta_title ?? $article->title)
@section('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->content), 150))
@section('meta_keywords', $article->keywords)

@if($article->featured_image)
    @section('meta_image', asset('storage/' . $article->featured_image))
@endif

@section('schema_json')
    @include('frontend.articles.partials.json-ld')
@endsection

@section('content')
<div class="pd-top-75 pd-bottom-50" style="background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Breadcrumbs -->
                @php
                    $breadcrumbs = [];
                    if($article->category) {
                        $breadcrumbs[$article->category->name] = route('category.show', $article->category->slug);
                    }
                    $breadcrumbs[$article->title] = '#';
                @endphp
                @include('frontend.partials.breadcrumbs', ['links' => $breadcrumbs])

                <div class="single-post-wrap bg-white p-4 p-md-5 rounded-lg shadow-sm">
                    <div class="thumb mb-4 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                        @if($article->featured_image)
                            <img class="w-100 transition-all hover-zoom" src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" style="object-fit: cover; max-height: 450px;">
                        @endif
                    </div>
                    <div class="details">
                        <div class="post-meta-single mb-3">
                            <ul class="d-flex flex-wrap align-items-center" style="gap: 15px; list-style: none; padding: 0;">
                                @if($article->category)
                                <li><a href="{{ route('category.show', $article->category->slug) }}" class="tag-premium">{{ $article->category->name }}</a></li>
                                @endif
                                
                                <li class="text-muted small d-flex align-items-center">
                                    <i class="fa fa-user-circle-o mr-2 text-primary"></i> <a href="{{ route('author.show', $article->user->username ?? Str::slug($article->user->name)) }}" class="text-dark font-weight-bold">{{ $article->user->name }}</a>
                                </li>
                                <li class="text-muted small d-flex align-items-center">
                                    <i class="fa fa-calendar-check-o mr-2 text-primary"></i> {{ $article->published_at->translatedFormat('d F Y') }}
                                </li>
                                <li class="text-muted small d-flex align-items-center">
                                    <i class="fa fa-eye mr-2 text-primary"></i> {{ $article->views }} {{ __('frontend.views') }}
                                </li>
                            </ul>
                        </div>
                        
                        <h1 class="title font-weight-bold mb-4" style="font-size: 2.5rem; line-height: 1.2; color: #0f172a;">{{ $article->title }}</h1>
                        
                        <!-- Premium Table of Contents -->
                        <div id="toc-container" class="toc-wrapper mb-5 d-none">
                            <div class="toc-card shadow-sm border-0 rounded-lg p-4 bg-white" style="border-left: 4px solid #0d6efd !important;">
                                <div class="d-flex align-items-center justify-content-between mb-3" style="cursor: pointer;" onclick="toggleTOC()">
                                    <h6 class="m-0 font-weight-bold d-flex align-items-center" style="letter-spacing: 0.5px; color: #0f172a;">
                                        <i class="fa fa-list-ul mr-2 text-primary"></i> {{ __('frontend.table_of_contents') ?? 'DAFTAR ISI' }}
                                    </h6>
                                    <i id="toc-chevron" class="fa fa-chevron-down text-muted transition-all"></i>
                                </div>
                                <div id="toc-content" class="toc-list-wrap">
                                    <ul id="toc-list" class="m-0 p-0" style="list-style: none;"></ul>
                                </div>
                            </div>
                        </div>

                        <div id="article-content" class="article-content mt-4" style="font-size: 1.15rem; line-height: 1.8; color: #334155;">
                            @php
                                $adScript = \App\Models\Configuration::where('key', 'ad_in_article_script')->value('value');
                                $readAlso = $relatedArticles->shuffle()->first();
                            @endphp
                            {!! \App\Helpers\ContentInjector::inject($article->content, $adScript, $readAlso) !!}
                        </div>

                        <!-- Social Share -->
                        <div class="post-meta-single mt-5 pt-4 border-top">
                            <h6 class="mb-3 font-weight-bold text-uppercase" style="letter-spacing: 1px; font-size: 13px;">{{ __('frontend.share_article') }}</h6>
                            <div class="social-share-buttons d-flex flex-wrap" style="gap: 12px;">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn-premium-social fb" title="Share on Facebook"><i class="fa fa-facebook"></i></a>
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="btn-premium-social tw" title="Share on Twitter"><i class="fa fa-twitter"></i></a>
                                <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" class="btn-premium-social wa" title="Share on WhatsApp"><i class="fa fa-whatsapp"></i></a>
                                <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}" target="_blank" class="btn-premium-social tg" title="Share on Telegram"><i class="fa fa-telegram"></i></a>
                                <button onclick="copyToClipboard('{{ request()->url() }}')" class="btn-premium-social link" title="Copy Link"><i class="fa fa-link"></i></button>
                            </div>
                        </div>

@push('styles')
<style>
    .tag-premium {
        background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        color: #fff !important;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none !important;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
    }
    .tag-premium:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(13, 110, 253, 0.3); color: #fff; }
    
    .btn-premium-social {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 18px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        text-decoration: none !important;
    }
    .btn-premium-social:hover { transform: translateY(-5px); color: #fff; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .fb { background: #1877f2; }
    .tw { background: #1da1f2; }
    .wa { background: #25d366; }
    .tg { background: #0088cc; }
    .link { background: #64748b; }
    
    .hover-zoom:hover { transform: scale(1.02); }
    .transition-all { transition: all 0.5s ease; }
    
    .article-content blockquote {
        border-left: 5px solid #0d6efd;
        padding: 20px;
        background: #f1f5f9;
        border-radius: 0 15px 15px 0;
        font-style: italic;
        margin: 30px 0;
    }
    .article-content img { border-radius: 15px; margin: 20px 0; max-width: 100%; height: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    
    .hover-up:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }
    
    .sticky-sidebar { position: sticky; top: 100px; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .rounded-lg { border-radius: 20px !important; }
    h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
    
    /* Premium TOC Styling */
    html { scroll-behavior: smooth; }
    .toc-wrapper { max-width: 600px; }
    .toc-card { transition: all 0.3s ease; border: 1px solid #f1f5f9 !important; }
    .toc-list-wrap { overflow: hidden; transition: max-height 0.4s ease; max-height: 1000px; }
    .toc-list-wrap.collapsed { max-height: 0; }
    .toc-link { 
        display: block; 
        padding: 6px 0; 
        color: #475569 !important; 
        font-size: 14px; 
        text-decoration: none !important; 
        transition: all 0.2s; 
        border-bottom: 1px dotted transparent;
    }
    .toc-link:hover { color: #0d6efd !important; padding-left: 5px; }
    .toc-link.h3-link { color: #64748b !important; font-size: 13.5px; }
    .chevron-rotate { transform: rotate(-180deg); }
    
    /* Adjust for fixed navbar if any */
    :target::before {
        content: "";
        display: block;
        height: 100px;
        margin-top: -100px;
    }
</style>
@endpush

@push('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Link berhasil disalin!');
        }, function(err) {
            console.error('Gagal menyalin: ', err);
        });
    }

    function toggleTOC() {
        const content = document.getElementById('toc-content');
        const chevron = document.getElementById('toc-chevron');
        content.classList.toggle('collapsed');
        chevron.classList.toggle('chevron-rotate');
    }

    document.addEventListener("DOMContentLoaded", function () {
        const content = document.getElementById("article-content");
        const tocContainer = document.getElementById("toc-container");
        const tocList = document.getElementById("toc-list");

        if (!content || !tocList) return;

        const headings = content.querySelectorAll("h2, h3");

        if (headings.length > 0) {
            tocContainer.classList.remove('d-none');
            
            headings.forEach((heading, index) => {
                const id = "section-" + index;
                heading.setAttribute("id", id);
                heading.classList.add('scroll-margin');

                const li = document.createElement("li");
                li.className = "toc-item border-bottom-faint";
                if (heading.tagName === "H3") li.style.paddingLeft = "20px";

                const a = document.createElement("a");
                a.href = "#" + id;
                a.innerHTML = heading.innerText;
                a.className = "toc-link " + (heading.tagName === "H3" ? "h3-link" : "h2-link");

                li.appendChild(a);
                tocList.appendChild(li);
            });
        }
    });
</script>
@endpush

                    </div>
                    
                    <!-- Related Posts -->
                    @if($relatedArticles->count() > 0)
                    <div class="related-post-area pd-top-50 mt-4 pt-4 border-top">
                        <div class="section-title mb-4">
                            <h5 class="title font-weight-bold" style="position: relative; display: inline-block;">
                                {{ __('frontend.related_posts') }}
                                <span style="position: absolute; bottom: -8px; left: 0; width: 40px; height: 3px; background: #0d6efd;"></span>
                            </h5>
                        </div>
                        <div class="row">
                            @foreach($relatedArticles as $related)
                            <div class="col-md-4 mb-4">
                                <div class="card border-0 h-100 shadow-sm transition-all hover-up" style="border-radius: 15px; overflow: hidden;">
                                    <div class="thumb" style="height: 160px; overflow: hidden;">
                                        @if($related->featured_image)
                                            <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 100%; width: 100%;">
                                                <i class="fa fa-newspaper-o text-muted fa-2x"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body p-3">
                                        <p class="text-muted small mb-2"><i class="fa fa-clock-o"></i> {{ $related->published_at->translatedFormat('d M Y') }}</p>
                                        <h6 class="title m-0" style="font-size: 15px; line-height: 1.5;"><a href="{{ route('article.show', $related->slug) }}" class="text-dark font-weight-bold">{{ Str::limit($related->title, 50) }}</a></h6>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif



                    <!-- Comments Section -->
                    <div class="mt-5 p-4 bg-light rounded-lg">
                        @include('frontend.articles.partials.comments')
                    </div>
                    
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-sidebar">
                    <div class="section-title mb-4">
                        <h6 class="title font-weight-bold">{{ __('frontend.recent_posts') }}</h6>
                    </div>
                    @foreach($recentArticles as $recent)
                    <div class="media-post-wrap-2 media d-flex align-items-center mb-4 bg-white p-2 rounded-lg shadow-xs hover-up transition-all">
                        <div class="thumb shadow-sm" style="width: 75px; height: 75px; flex-shrink: 0; overflow: hidden; border-radius: 12px; margin-right: 15px;">
                            @if($recent->featured_image)
                                <img src="{{ asset('storage/' . $recent->featured_image) }}" alt="{{ $recent->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light" style="width: 100%; height: 100%;">
                                    <i class="fa fa-file-text-o text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="media-body">
                            <h6 class="m-0" style="line-height: 1.4; font-size: 14px;"><a href="{{ route('article.show', $recent->slug) }}" class="text-dark font-weight-bold">{{ Str::limit($recent->title, 45) }}</a></h6>
                            <div class="meta text-muted small mt-1">
                                <span><i class="fa fa-clock-o"></i> {{ $recent->published_at->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="widget widget_add mt-4 shadow-sm rounded-lg overflow-hidden">
                        @include('frontend.partials.ad-sidebar')
                    </div>

                    <div class="mt-4 shadow-sm rounded-lg overflow-hidden">
                        @include('frontend.partials.newsletter-sidebar')
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>


@endsection
