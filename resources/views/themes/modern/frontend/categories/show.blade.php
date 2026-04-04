@extends('themes.modern.frontend.layouts.app')

@section('title', $category->name . ' - ' . ($settings['site_name'] ?? 'The Editorial Authority'))

@section('content')
<main class="max-w-7xl mx-auto px-6 pt-12 lg:pl-72 flex flex-col md:flex-row gap-12 min-h-screen">
    
    <!-- Sidebar Kiri (Desktop Only) -->
    <aside class="hidden lg:flex flex-col w-64 fixed left-0 top-0 pt-24 px-4 h-full bg-surface-container-low dark:bg-slate-900 rounded-r-lg z-40">
        <div class="mb-8 px-2">
            <h2 class="font-bold text-on-surface text-sm uppercase tracking-widest">Editorial Hub</h2>
            <p class="text-xs text-on-surface-variant">Precision Storytelling</p>
        </div>
        <div class="flex flex-col gap-2">
            <a href="{{ url('/') }}" class="flex items-center gap-3 p-3 text-on-surface-variant hover:bg-surface-container-highest dark:hover:bg-slate-800 rounded-lg transition-transform hover:translate-x-1">
                <span class="material-symbols-outlined">trending_up</span>
                <span class="font-medium text-sm">Trending Now</span>
            </a>
            <a href="{{ route('category.index') }}" class="flex items-center gap-3 p-3 text-on-surface-variant hover:bg-surface-container-highest dark:hover:bg-slate-800 rounded-lg transition-transform hover:translate-x-1">
                <span class="material-symbols-outlined">visibility</span>
                <span class="font-medium text-sm">Most Read</span>
            </a>
        </div>
        <div class="mt-auto pb-8 flex flex-col gap-4">
            <button class="bg-secondary text-white py-3 px-4 rounded-xl text-xs font-bold uppercase tracking-widest shadow-sm hover:brightness-110 transition-all">
                Newsletter Signup
            </button>
            <div class="flex gap-4 px-2 text-[10px] text-on-surface-variant uppercase tracking-tighter">
                <a class="hover:text-primary" href="#">Privacy</a>
                <a class="hover:text-primary" href="#">Terms</a>
            </div>
        </div>
    </aside>

    <div class="flex-1">
        <!-- Header Kategori -->
        <div class="mb-12">
            <span class="bg-tertiary-container text-on-tertiary-container px-3 py-1 text-[10px] font-bold tracking-widest rounded-full uppercase">
                {{ $category->name }} News
            </span>
            <h2 class="text-5xl font-headline font-extrabold mt-4 text-on-surface leading-none tracking-tight">
                {{ $category->name }}
            </h2>
            <div class="h-1 w-24 bg-secondary mt-6"></div>
            @if($category->description)
                <p class="mt-6 text-on-surface-variant font-body text-lg leading-relaxed max-w-2xl">
                    {{ $category->description }}
                </p>
            @endif
        </div>

        @if($articles->isEmpty())
            <div class="py-24 text-center">
                <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">newspaper</span>
                <h3 class="text-2xl font-headline font-bold text-on-surface">Belum ada berita di kategori ini.</h3>
                <a href="{{ url('/') }}" class="inline-block mt-8 bg-black text-white px-8 py-3 rounded-xl font-bold hover:bg-secondary transition-colors">Kembali ke Home</a>
            </div>
        @else
            <div class="space-y-16">
                <!-- Featured Article (Post Pertama) -->
                @php $featured = $articles->first(); @endphp
                <article class="group cursor-pointer" onclick="window.location='{{ route('article.show', $featured->slug) }}'">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                        <div class="md:col-span-7 overflow-hidden rounded-xl bg-surface-container-low aspect-[16/9]">
                            @if($featured->image)
                                <img src="{{ asset('storage/' . $featured->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 shadow-md">
                            @endif
                        </div>
                        <div class="md:col-span-5">
                            <span class="text-[10px] font-bold text-secondary uppercase tracking-widest">{{ $featured->category->name }}</span>
                            <h3 class="text-3xl font-headline font-bold mt-2 leading-tight group-hover:text-on-tertiary-fixed-variant transition-colors">
                                {{ $featured->title }}
                            </h3>
                            <p class="text-on-surface-variant mt-4 line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($featured->content), 150) }}
                            </p>
                            <div class="flex items-center gap-4 mt-6">
                                <div class="w-8 h-8 rounded-full bg-surface-container-high overflow-hidden">
                                    @if($featured->user->image)
                                        <img src="{{ asset('storage/' . $featured->user->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($featured->user->name) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-on-surface">By {{ $featured->user->name }}</p>
                                    <p class="text-[10px] text-on-surface-variant uppercase tracking-tighter">14 Min Read • {{ $featured->published_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Grid Articles (Post Selanjutnya) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    @foreach($articles->skip(1)->take(4) as $article)
                        <article class="group cursor-pointer" onclick="window.location='{{ route('article.show', $article->slug) }}'">
                            <div class="rounded-xl overflow-hidden bg-surface-container-low aspect-[4/3] mb-6">
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 shadow-sm">
                                @endif
                            </div>
                            <span class="text-[10px] font-bold text-on-tertiary-container uppercase tracking-widest">{{ $article->category->name }}</span>
                            <h3 class="text-2xl font-headline font-bold mt-2 leading-snug group-hover:text-secondary transition-colors">
                                {{ $article->title }}
                            </h3>
                            <p class="text-sm text-on-surface-variant mt-3 line-clamp-2">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>
                        </article>
                    @endforeach
                </div>

                <!-- Exclusive Section (Post Ke-6 jika ada) -->
                @if($articles->count() >= 6)
                    @php $exclusive = $articles->get(5); @endphp
                    <article class="bg-surface-container-low rounded-xl p-8 flex flex-col md:flex-row gap-8 items-center border border-outline-variant/10 cursor-pointer" onclick="window.location='{{ route('article.show', $exclusive->slug) }}'">
                        <div class="flex-1">
                            <span class="bg-secondary text-white px-2 py-0.5 text-[9px] font-bold rounded uppercase">Exclusive Longform</span>
                            <h3 class="text-4xl font-headline font-bold mt-4 leading-tight">{{ $exclusive->title }}</h3>
                            <p class="text-on-surface-variant mt-4 leading-relaxed italic line-clamp-2">"{{ Str::limit(strip_tags($exclusive->content), 120) }}"</p>
                            <button class="mt-8 flex items-center gap-2 font-bold text-xs uppercase tracking-widest border-b-2 border-primary pb-1 hover:text-secondary hover:border-secondary transition-colors">
                                Baca Investigasi
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                        <div class="w-full md:w-1/3 aspect-square rounded-lg overflow-hidden grayscale hover:grayscale-0 transition-all duration-1000">
                            @if($exclusive->image)
                                <img src="{{ asset('storage/' . $exclusive->image) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </article>
                @endif
            </div>

            <!-- Pagination -->
            <nav class="mt-20 flex justify-between items-center py-8 border-t border-outline-variant/20">
                {{ $articles->links() }}
            </nav>
        @endif
    </div>

    <!-- Sidebar Kanan (Filter & Ads) -->
    <aside class="w-full md:w-80 flex flex-col gap-12">
        <section class="bg-surface-container-low p-6 rounded-xl">
            <h4 class="text-xs font-black uppercase tracking-widest mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">filter_list</span>
                Filter Berita
            </h4>
            <div class="space-y-6">
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-tighter text-on-surface-variant block mb-2">Waktu</label>
                    <select class="w-full bg-surface-container-lowest border-none rounded-lg text-sm font-medium py-3 px-4 focus:ring-1 focus:ring-primary/20">
                        <option>Terbaru</option>
                        <option>Minggu Ini</option>
                        <option>Bulan Ini</option>
                    </select>
                </div>
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-tighter text-on-surface-variant block mb-2">Urutkan</label>
                    <div class="flex flex-col gap-2">
                        <button class="text-left text-sm font-bold p-3 bg-white rounded-lg shadow-sm">Berita Terkini</button>
                        <button class="text-left text-sm font-medium p-3 hover:bg-white/50 rounded-lg transition-colors text-on-surface-variant">Terpopuler</button>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h4 class="text-xs font-black uppercase tracking-widest mb-6 text-on-surface">Trending Topics</h4>
            <div class="flex flex-wrap gap-2">
                @php $allCategories = \App\Models\Category::take(6)->get(); @endphp
                @foreach($allCategories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="bg-surface-container-high text-on-surface-variant px-4 py-2 text-[10px] font-bold tracking-widest rounded-full uppercase hover:bg-primary hover:text-white transition-all">
                        #{{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </section>

        <section class="sticky top-32">
            <div class="bg-surface-container-highest rounded-xl aspect-[4/5] flex flex-col items-center justify-center p-8 text-center border-2 border-dashed border-outline-variant/30">
                @php $sidebarAd = \App\Models\Configuration::where('key', 'ad_sidebar_script')->value('value'); @endphp
                @if($sidebarAd)
                    {!! $sidebarAd !!}
                @else
                    <span class="material-symbols-outlined text-4xl text-outline-variant mb-4">ad_units</span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Iklan</span>
                    <p class="text-xs text-on-surface-variant mt-4 leading-relaxed font-medium">Dukung jurnalisme independen dengan berlangganan edisi khusus kami.</p>
                @endif
            </div>
        </section>
    </aside>
</main>
@endsection
