@extends('themes.modern.frontend.layouts.app')

@section('title', $category->name . ' - ' . ($settings['site_name'] ?? 'NewsHub'))

@section('content')
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white pt-16 pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-blue-200 mb-8">
                    <a href="{{ url('/') }}" class="hover:text-white">Home</a>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-white">Kategori</span>
                </nav>
                <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6">
                    {{ $category->name }}
                </h1>
                @if($category->description)
                    <p class="text-xl text-blue-100 leading-relaxed max-w-2xl opacity-90 border-l-4 border-white/30 pl-6">
                        {{ $category->description }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 pb-24">
        @if($articles->isEmpty())
            <div class="bg-white rounded-[3rem] p-24 text-center shadow-xl border border-gray-100">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-folder-open text-gray-300 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Berita</h3>
                <p class="text-gray-500 mb-10 max-w-md mx-auto">Mohon maaf, saat ini belum ada berita yang diterbitkan dalam kategori ini.</p>
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                    Kembali ke Beranda
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                <!-- Main Feed -->
                <div class="lg:col-span-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($articles as $article)
                            <a href="{{ route('article.show', $article->slug) }}"
                                class="group bg-white border border-gray-100 rounded-3xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col">
                                <div class="h-48 relative overflow-hidden bg-gray-200">
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div
                                        class="absolute top-4 left-4 bg-blue-600 text-white px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest shadow-lg">
                                        {{ $article->category->name }}
                                    </div>
                                </div>
                                <div class="p-6 flex-grow flex flex-col">
                                    <span class="text-xs text-gray-500 font-bold mb-3"><i class="far fa-clock mr-1"></i>
                                        {{ $article->published_at->diffForHumans() }}</span>
                                    <h3
                                        class="text-lg font-bold text-gray-900 leading-snug group-hover:text-blue-600 transition-colors">
                                        {{ $article->title }}
                                    </h3>
                                    <p class="text-gray-500 text-sm mt-3 line-clamp-2">
                                        {{ Str::limit(strip_tags($article->content), 80) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-16 flex justify-center">
                        {{ $articles->links() }}
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-4 space-y-12">
                    <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm sticky top-24">
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-8 flex items-center">
                            <span class="w-8 h-px bg-gray-200 mr-4"></span> Populer
                        </h3>
                        <div class="space-y-8">
                            @foreach($trendingArticles->take(6) as $index => $trend)
                                <a href="{{ route('article.show', $trend->slug) }}" class="group flex gap-5">
                                    <span class="text-3xl font-black text-gray-100 group-hover:text-blue-600/20 transition-colors">0{{ $index + 1 }}</span>
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-800 group-hover:text-blue-600 transition-colors leading-snug">
                                            {{ $trend->title }}
                                        </h4>
                                        <span class="text-[10px] text-blue-500 font-extrabold uppercase mt-2 block tracking-widest">
                                            {{ $trend->category->name }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        <div class="mt-12 pt-12 border-t border-gray-50">
                            <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-6 px-2">Kategori Lainnya</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach(\App\Models\Category::where('id', '!=', $category->id)->take(8)->get() as $otherCat)
                                    <a href="{{ route('category.show', $otherCat->slug) }}" class="px-5 py-2.5 bg-gray-50 hover:bg-blue-600 hover:text-white rounded-xl text-xs font-bold text-gray-600 transition-all uppercase tracking-wider">
                                        {{ $otherCat->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        @endif
    </main>
@endsection

