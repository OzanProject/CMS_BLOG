@extends('themes.modern.frontend.layouts.app')

@section('title', ($article->title ?? 'Berita Terkini') . ' - ' . ($settings['site_name'] ?? 'NewsHub'))

@push('styles')
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Article",
      "headline": "{{ $article->title ?? '' }}",
      "image": ["{{ isset($article->image) ? asset('storage/' . $article->image) : '' }}"],
      "datePublished": "{{ isset($article->published_at) ? $article->published_at->toIso8601String() : '' }}",
      "author": {
        "@@type": "Person",
        "name": "{{ $article->user->name ?? 'Admin' }}"
      }
    }
    </script>
    <style>
        .article-content {
            font-size: 1.125rem;
            line-height: 1.8;
            color: #374151;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content h2 {
            font-weight: 800;
            font-size: 1.875rem;
            color: #111827;
            margin-top: 2.5rem;
            margin-bottom: 1.25rem;
            letter-spacing: -0.025em;
        }

        .article-content img {
            border-radius: 1.5rem;
            margin: 2.5rem 0;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
            <div class="max-w-4xl mx-auto">
                <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gray-400 mb-8">
                    <a href="{{ url('/') }}" class="hover:text-blue-600">Home</a>
                    @if(isset($article->category))
                        <i class="fas fa-chevron-right text-[8px]"></i>
                        <a href="{{ route('category.show', $article->category->slug) }}" class="hover:text-blue-600">{{ $article->category->name }}</a>
                    @endif
                </nav>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-8">
                    {{ $article->title }}
                </h1>

                <div class="flex flex-wrap items-center justify-between gap-6 py-8 border-y border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-100 to-purple-100 overflow-hidden ring-2 ring-gray-50 text-center flex items-center justify-center">
                            @if(isset($article->user->image))
                                <img src="{{ asset('storage/' . $article->user->image) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-blue-500"></i>
                            @endif
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-base">{{ $article->user->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500 font-medium">{{ $article->published_at->format('l, d F Y | H:i') }} WIB</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-sky-50 text-sky-500 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-all">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-green-50 text-green-500 flex items-center justify-center hover:bg-green-500 hover:text-white transition-all">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <div class="lg:col-span-8">
                @if(!empty($article->image))
                    <div class="mb-12">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-auto rounded-[2.5rem] shadow-2xl ring-1 ring-gray-200">
                    </div>
                @endif

                <div class="article-content font-sans">
                    {!! \App\Helpers\ContentInjector::inject($article->content, $settings) !!}
                </div>

                @if(isset($relatedArticles) && $relatedArticles->isNotEmpty())
                    <section class="mt-24 pt-16 border-t border-gray-100">
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-10 flex items-center">
                            <span class="w-2 h-8 bg-blue-600 rounded-full mr-4"></span>
                            Baca Juga
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($relatedArticles as $rel)
                                <a href="{{ route('article.show', $rel->slug) }}" class="group flex gap-5 bg-white p-4 rounded-3xl border border-gray-100 hover:shadow-xl transition-all">
                                    <div class="w-24 h-24 flex-shrink-0 rounded-2xl overflow-hidden bg-gray-100">
                                        <img src="{{ asset('storage/' . $rel->image) }}" class="w-full h-full object-cover grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition-all">
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h4 class="font-bold text-gray-900 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $rel->title }}
                                        </h4>
                                        <span class="text-[10px] text-gray-400 font-bold uppercase mt-2 tracking-widest">
                                            {{ $rel->published_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            <aside class="lg:col-span-4 space-y-16">
                <!-- Trending Sidebar -->
                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-8 flex items-center">
                        <span class="w-8 h-px bg-gray-200 mr-4"></span> Populer
                    </h3>
                    <div class="space-y-8">
                        @foreach($trendingArticles->take(5) as $index => $trend)
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
                </div>

                <!-- Newsletter Card -->
                <div class="bg-gradient-to-br from-gray-900 to-black p-10 rounded-[2.5rem] text-center relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <h4 class="text-2xl font-extrabold text-white mb-4">NewsHub Brief</h4>
                        <p class="text-gray-400 text-xs mb-8 leading-relaxed">Berlangganan untuk mendapatkan ringkasan berita terbaik setiap pagi.</p>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-4">
                            @csrf
                            <input name="email" type="email" placeholder="Email Anda" class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-5 py-4 text-sm text-white focus:ring-2 focus:ring-blue-600 outline-none" required>
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-4 rounded-2xl text-[10px] uppercase tracking-widest shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                                Berlangganan
                            </button>
                        </form>
                    </div>
                </div>
            </aside>
        </div>
    </main>
@endsection

