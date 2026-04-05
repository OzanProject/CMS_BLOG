@extends('themes.modern.frontend.layouts.app')

@section('title', $user->name . ' - ' . ($settings['site_name'] ?? 'NewsHub'))

@section('content')
    <section class="bg-white border-b border-gray-100 py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center gap-12 text-center md:text-left">
                <div class="w-48 h-48 bg-gradient-to-br from-blue-100 to-purple-100 rounded-[2.5rem] p-1 shadow-2xl relative">
                    <div class="w-full h-full rounded-[2.2rem] overflow-hidden bg-white">
                        @if($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-user text-5xl text-gray-200"></i>
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg border-4 border-white">
                        <i class="fas fa-pen-nib text-white text-sm"></i>
                    </div>
                </div>
                
                <div class="flex-1">
                    <div class="inline-flex items-center px-4 py-1.5 bg-blue-50 rounded-full text-[10px] font-black uppercase tracking-widest text-blue-600 mb-6">
                        Penulis Terverifikasi
                    </div>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 tracking-tight">{{ $user->name }}</h1>
                    @if($user->bio)
                        <p class="text-gray-500 text-lg leading-relaxed mb-8 max-w-2xl font-medium">
                            {{ $user->bio }}
                        </p>
                    @endif
                    
                    <div class="flex items-center justify-center md:justify-start gap-10">
                        <div>
                            <span class="block text-3xl font-extrabold text-gray-900">{{ $articles->total() }}</span>
                            <span class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mt-1">Artikel</span>
                        </div>
                        <div class="flex gap-4 border-l border-gray-100 pl-10">
                            <a href="#" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all shadow-sm">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 pb-32">
        <div class="flex items-center justify-between mb-12">
            <h2 class="text-2xl font-extrabold text-gray-900">Publikasi Terbaru</h2>
            <div class="h-1 flex-grow max-w-[100px] bg-blue-600 rounded-full ml-6"></div>
        </div>

        @if($articles->isEmpty())
            <div class="py-24 text-center bg-gray-50 rounded-[3rem] border border-gray-100">
                <i class="fas fa-feather-alt text-gray-200 text-5xl mb-6"></i>
                <h3 class="text-xl font-bold text-gray-400">Belum ada publikasi dari penulis ini.</h3>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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

            <div class="mt-16 flex justify-center pt-16 border-t border-gray-50">
                {{ $articles->links() }}
            </div>
        @endif
    </main>
@endsection

