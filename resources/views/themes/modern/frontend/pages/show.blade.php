@extends('themes.modern.frontend.layouts.app')

@section('title', ($page->title ?? 'Page') . ' — ' . ($settings['site_name'] ?? 'TechJournal'))
@section('meta_description', Str::limit(strip_tags($page->content ?? ''), 160))

@section('content')
<main class="flex-grow w-full max-w-[1200px] mx-auto px-6 py-16">
    <article class="max-w-[800px] mx-auto bg-surface-container-lowest rounded-3xl shadow-premium p-8 md:p-16 border border-outline-variant/30">
        
        <header class="mb-12 border-b border-surface-container pb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-secondary-container/10 text-secondary border border-secondary/20 rounded-full mb-6">
                <span class="material-symbols-outlined text-[14px]">description</span>
                <span class="font-label-caps text-[10px] uppercase tracking-widest font-bold">
                    {{ 'Official Publication' }}
                </span>
            </div>

            <h1 class="font-h1 text-h1 text-on-surface mb-6 leading-tight tracking-tight">
                {{ $page->title }}
            </h1>

            <div class="flex items-center gap-4 font-meta text-sm text-on-surface-variant">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    <span>Last Updated: {{ $page->updated_at->format('F d, Y') }}</span>
                </div>
            </div>
        </header>

        <div class="prose-slate prose-lg max-w-none font-body-lg text-body-lg text-on-surface-variant leading-relaxed article-content">
            {!! $page->content !!}
        </div>

    </article>
</main>
@endsection
