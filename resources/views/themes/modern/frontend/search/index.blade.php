@extends('themes.modern.frontend.layouts.app')

@section('title', 'Pencarian: ' . $query . ' - ' . ($settings['site_name'] ?? 'NewsHub'))

@section('content')
    <section class="bg-gray-900 text-white pt-16 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gray-500 mb-8">
                    <a href="{{ url('/') }}" class="hover:text-white">Home</a>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-gray-300">Pencarian</span>
                </nav>
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
                    Hasil Pencarian untuk: <span class="text-blue-500">"{{ $query }}"</span>
                </h1>
                <p class="text-lg text-gray-400 font-medium">
                    Menampilkan <span class="text-white font-bold">{{ $articles->total() }}</span> artikel yang sesuai dengan kueri Anda.
                </p>
            </div>
            
            <div class="mt-12 max-w-xl">
                <form action="{{ route('search') }}" method="GET" class="relative group">
                    <input name="q" value="{{ $query }}" class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-6 py-5 text-sm text-white focus:border-blue-500 outline-none transition-all shadow-2xl placeholder:text-gray-600" placeholder="Cari berita lainnya...">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center hover:bg-blue-700 transition-all shadow-lg">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 pb-32">
        @if($articles->isEmpty())
            <div class="bg-white rounded-[3rem] p-24 text-center shadow-xl border border-gray-100 -mt-32 relative z-20">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-search-minus text-gray-300 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-10 max-w-md mx-auto">Maaf, kami tidak menemukan artikel yang sesuai dengan kata kunci yang Anda cari. Silakan coba dengan kata kunci yang berbeda.</p>
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                    Kembali ke Beranda
                </a>
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

            <div class="mt-16 flex justify-center border-t border-gray-100 pt-16">
                {{ $articles->links() }}
            </div>
        @endif
    </main>
@endsection

