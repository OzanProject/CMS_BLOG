@extends('themes.modern.frontend.layouts.app')

@section('title', __('frontend.categories') ?? 'All Categories' . ' — ' . ($settings['site_name'] ?? 'TechJournal'))

@section('content')
<div class="max-w-[1200px] mx-auto px-8 py-12">

    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6 flex items-center text-sm font-meta text-outline">
        <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
        <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
        <span aria-current="page" class="text-on-surface font-medium">{{ __('frontend.categories') ?? 'Categories' }}</span>
    </nav>

    {{-- Page Header --}}
    <div class="mb-12 border-l-4 border-secondary-container pl-4">
        <h1 class="font-h1 text-h1 text-on-surface mb-2">{{ __('frontend.explore_categories') ?? 'Explore Categories' }}</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant">{{ __('frontend.categories_desc') ?? 'Deep investigations across every domain of modern life.' }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categories as $cat)
            <a href="{{ route('category.show', $cat->slug) }}" class="group block p-8 bg-surface-container-lowest border border-surface-variant rounded-xl hover:bg-primary-container hover:border-primary-container transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="flex flex-col h-full justify-between gap-8">
                    <div>
                        <span class="font-label-caps text-[11px] tracking-widest uppercase text-secondary group-hover:text-on-primary-container mb-4 block transition-colors">
                            {{ $cat->articles_count ?? 0 }} {{ __('frontend.articles') ?? 'Articles' }}
                        </span>
                        <h3 class="font-h2 text-h2 text-on-surface group-hover:text-on-primary transition-colors leading-tight">
                            {{ $cat->name }}
                        </h3>
                    </div>
                    @if($cat->description)
                        <p class="font-body-md text-[15px] text-on-surface-variant group-hover:text-on-primary-container/80 transition-colors line-clamp-2">
                            {{ $cat->description }}
                        </p>
                    @endif
                    <div class="flex items-center gap-2 font-label-caps text-[11px] uppercase tracking-widest text-secondary group-hover:text-on-primary-container transition-colors">
                        <span>Explore Archives</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
