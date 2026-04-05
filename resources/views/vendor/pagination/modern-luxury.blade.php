@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-slate-700 bg-slate-900/50 rounded-lg cursor-not-allowed">
                <span class="material-symbols-outlined text-sm">chevron_left</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-4 py-2 bg-slate-900 border border-slate-800 text-slate-400 rounded-lg hover:border-amber-500 hover:text-amber-500 transition-all shadow-lg">
                <span class="material-symbols-outlined text-sm">chevron_left</span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2 text-slate-600" aria-disabled="true">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="px-4 py-2 bg-amber-500 text-slate-950 font-black rounded-lg shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 bg-slate-900 border border-slate-800 text-slate-400 rounded-lg hover:border-amber-500 hover:text-amber-500 transition-all shadow-lg" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-4 py-2 bg-slate-900 border border-slate-800 text-slate-400 rounded-lg hover:border-amber-500 hover:text-amber-500 transition-all shadow-lg">
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </a>
        @else
            <span class="px-4 py-2 text-slate-700 bg-slate-900/50 rounded-lg cursor-not-allowed">
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </span>
        @endif
    </nav>
@endif
