@extends('themes.modern.frontend.layouts.app')

@section('title', 'All Categories - ' . ($settings['site_name'] ?? 'The Editorial Authority'))

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-12 border-l-4 border-secondary pl-6">
        <span class="text-[0.6875rem] font-bold tracking-[0.3em] uppercase text-on-surface-variant mb-2 block">Our Archives</span>
        <h1 class="text-5xl font-headline font-bold text-on-surface mb-2">Explore by Category</h1>
        <p class="text-on-surface-variant font-body">Deep investigations across every domain of modern life.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($categories as $cat)
            <a href="{{ route('category.show', $cat->slug) }}" class="group block p-8 bg-surface-container-low border border-outline-variant/10 rounded-2xl hover:bg-black transition-all duration-500 shadow-sm hover:shadow-2xl hover:-translate-y-2">
                <div class="flex flex-col h-full justify-between gap-12">
                    <div>
                        <span class="text-[0.6875rem] font-bold tracking-widest uppercase text-secondary mb-4 block group-hover:text-white transition-colors">{{ $cat->articles_count ?? '0' }} Stories</span>
                        <h3 class="text-3xl font-headline font-bold text-on-surface group-hover:text-white transition-colors leading-tight">
                            {{ $cat->name }}
                        </h3>
                    </div>
                    @if($cat->description)
                        <p class="text-sm text-on-surface-variant group-hover:text-white/60 transition-colors line-clamp-2">
                            {{ $cat->description }}
                        </p>
                    @endif
                    <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-secondary group-hover:text-white transition-colors">
                        <span>Explore Archives</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</main>
@endsection
