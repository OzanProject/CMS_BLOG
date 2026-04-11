@extends('themes.modern.frontend.layouts.app')

@section('content')
    @php $heroArticle = $bannerArticles->shift() ?? $latestArticles->first(); @endphp

    <section class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 text-white pt-16 pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="absolute inset-0 bg-black/10"></div>

            <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8 z-10">
                    <div
                        class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-widest">
                        <i class="fas fa-bolt mr-2 text-yellow-300"></i> BERITA TERKINI
                    </div>

                    @if($heroArticle)
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight">
                            <a href="{{ route('article.show', $heroArticle->slug) }}"
                                class="hover:underline decoration-4 underline-offset-8">
                                {{ $heroArticle->title }}
                            </a>
                        </h1>
                        <p class="text-lg text-blue-100 leading-relaxed max-w-lg line-clamp-3">
                            {{ Str::limit(strip_tags($heroArticle->content), 150) }}
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <a href="{{ route('article.show', $heroArticle->slug) }}"
                                class="group bg-white text-gray-900 px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-book-open mr-3 group-hover:rotate-12 transition-transform text-blue-600"></i>
                                Baca Berita
                            </a>
                        </div>
                    @endif
                </div>

                @if($heroArticle)
                    <div class="relative mt-8 lg:mt-0">
                        <img src="{{ asset('storage/' . $heroArticle->image) }}" alt="Hero"
                            class="w-full h-80 md:h-[400px] object-cover rounded-3xl shadow-2xl animate-pulse-slow ring-8 ring-white/10">
                        <div
                            class="absolute -bottom-6 -right-6 md:-bottom-8 md:-right-8 w-20 h-20 md:w-24 md:h-24 bg-gradient-to-tr from-yellow-400 to-orange-500 rounded-full animate-bounce shadow-xl flex items-center justify-center">
                            <i class="fas fa-star text-white text-3xl"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="py-20 bg-white -mt-10 rounded-t-[3rem] relative z-20 shadow-[0_-10px_40px_rgba(0,0,0,0.1)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Terbaru Hari Ini</h2>
                    <div class="w-20 h-1.5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($latestArticles->take(8) as $article)
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

            <div class="mt-12 flex justify-center">
                {{ $latestArticles->links() }}
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-16">Eksplor Kategori</h2>

            @php
                // Array untuk memberi ikon dan warna berbeda pada setiap kategori
                $styles = [
                    ['icon' => 'fa-home', 'bg' => 'from-red-500 to-orange-500', 'text' => 'group-hover:text-red-600'],
                    ['icon' => 'fa-globe', 'bg' => 'from-blue-500 to-indigo-500', 'text' => 'group-hover:text-blue-600'],
                    ['icon' => 'fa-chart-line', 'bg' => 'from-green-500 to-teal-500', 'text' => 'group-hover:text-green-600'],
                    ['icon' => 'fa-laptop', 'bg' => 'from-purple-500 to-pink-500', 'text' => 'group-hover:text-purple-600'],
                    ['icon' => 'fa-futbol', 'bg' => 'from-yellow-500 to-orange-500', 'text' => 'group-hover:text-yellow-600'],
                    ['icon' => 'fa-heart', 'bg' => 'from-pink-500 to-rose-500', 'text' => 'group-hover:text-pink-600'],
                ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categories as $index => $cat)
                    @php $style = $styles[$index % count($styles)]; @endphp
                    <a href="{{ route('category.show', $cat->slug) }}"
                        class="group p-6 rounded-3xl bg-white shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center border border-gray-100">
                        <div
                            class="w-16 h-16 bg-gradient-to-r {{ $style['bg'] }} rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg">
                            <i class="fas {{ $style['icon'] }} text-white text-2xl"></i>
                        </div>
                        <h3
                            class="font-extrabold text-gray-800 text-sm uppercase tracking-wider {{ $style['text'] }} transition-colors">
                            {{ $cat->name }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured YouTube Video --}}
    @php
        $youtubeUrl = $settings['homepage_youtube_url'] ?? null;
        $videoId = '';
        if ($youtubeUrl) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubeUrl, $match)) {
                $videoId = $match[1];
            }
        }
    @endphp

    @if($videoId)
        <section class="py-20 bg-[#0d1117] border-t border-slate-800">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-white mb-2">Editor's Choice</h2>
                    <div class="w-16 h-1 bg-amber-500 mx-auto rounded-full"></div>
                </div>
                <div class="relative aspect-video rounded-3xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-slate-700">
                    <iframe 
                        src="https://www.youtube.com/embed/{{ $videoId }}" 
                        class="absolute inset-0 w-full h-full"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </section>
    @endif

    <section class="py-20 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="mb-10">
                <h2 class="text-3xl md:text-5xl font-extrabold mb-6">Dapatkan Update Harian</h2>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                    Berlangganan newsletter kami untuk mendapatkan berita terbaru langsung ke email Anda.
                </p>
            </div>
            <div
                class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-10 max-w-2xl mx-auto shadow-2xl">
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <input name="email" type="email" placeholder="Masukkan alamat email..." required
                        class="flex-1 px-6 py-4 bg-gray-900/50 border border-gray-700 rounded-2xl text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all duration-200">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 px-8 py-4 rounded-2xl font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        Berlangganan
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection