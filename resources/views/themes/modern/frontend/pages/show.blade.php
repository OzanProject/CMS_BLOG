@extends('themes.modern.frontend.layouts.app')

@section('title', ($page->title ?? 'Page') . ' — ' . ($settings['site_name'] ?? 'TechJournal'))
@section('meta_description', Str::limit(strip_tags($page->content ?? ''), 160))

@section('content')
<div class="max-w-[1200px] mx-auto px-8 py-12">

    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6 flex items-center text-sm font-meta text-outline">
        <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
        <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
        <span aria-current="page" class="text-on-surface font-medium">{{ $page->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-8">
            <h1 class="font-h1 text-h1 text-on-surface mb-8">{{ $page->title }}</h1>
            <div class="article-content font-body-md text-body-md text-on-surface-variant leading-relaxed">
                {!! $page->content !!}
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4 space-y-8">
            {{-- Recent Articles --}}
            @if(isset($recentArticles) && $recentArticles->isNotEmpty())
            <div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant sticky top-24">
                <h4 class="font-h3 text-[18px] text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">schedule</span>
                    {{ __('frontend.recent_news') ?? 'Recent Articles' }}
                </h4>
                <div class="space-y-5">
                    @foreach($recentArticles->take(5) as $index => $recent)
                        <a href="{{ route('article.show', $recent->slug) }}" class="group flex gap-4">
                            <span class="font-h2 text-[24px] font-bold text-outline/30 group-hover:text-secondary/50 transition-colors leading-none pt-1">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div>
                                <h5 class="font-meta text-[14px] font-semibold text-on-surface group-hover:text-secondary transition-colors leading-snug">
                                    {{ Str::limit($recent->title, 55) }}
                                </h5>
                                <p class="text-[11px] text-outline mt-1">{{ $recent->published_at->format('M d, Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </aside>
    </div>
</div>
@endsection
