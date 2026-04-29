@extends('themes.modern.frontend.layouts.app')

@section('title', ($page->title ?? 'Page') . ' — ' . ($settings['site_name'] ?? 'TechJournal'))
@section('meta_description', Str::limit(strip_tags($page->content ?? ''), 160))

@section('content')
<main class="flex-grow w-full max-w-[1200px] mx-auto px-6 py-16">
    <article class="max-w-[720px] mx-auto bg-surface-container-lowest dark:bg-slate-900 rounded-xl shadow-[0_4px_16px_rgba(15,23,42,0.04)] p-8 md:p-12 border border-outline-variant dark:border-slate-800">
        
        <header class="mb-12 border-b border-outline-variant dark:border-slate-800 pb-8">
            <span class="inline-block px-3 py-1 bg-secondary-fixed text-on-secondary-fixed-variant font-label-caps text-[12px] uppercase tracking-widest rounded mb-4">
                {{ 'Legal Document' }}
            </span>
            <h1 class="font-h1 text-4xl font-extrabold text-on-surface dark:text-white mb-4 leading-tight">
                {{ $page->title }}
            </h1>
            <p class="font-meta text-sm text-on-surface-variant dark:text-slate-400">
                Last Updated: {{ $page->updated_at->format('F d, Y') }}
            </p>
        </header>

        <div class="prose prose-slate dark:prose-invert max-w-none font-body-lg text-lg text-on-surface-variant dark:text-slate-300 leading-relaxed article-content">
            {!! $page->content !!}
        </div>

    </article>
</main>
@endsection
