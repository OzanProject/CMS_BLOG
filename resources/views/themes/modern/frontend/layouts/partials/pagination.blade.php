@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center space-x-2 mt-12">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-surface-container-low text-outline cursor-default" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-surface-container-low text-on-surface hover:bg-secondary hover:text-on-secondary transition-all shadow-sm" aria-label="{{ __('pagination.previous') }}">
                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex items-center space-x-2 font-meta text-sm font-medium">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="inline-flex items-center justify-center w-10 h-10 text-outline cursor-default" aria-disabled="true">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-secondary text-on-secondary shadow-md">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-surface-container-low text-on-surface hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-all" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-surface-container-low text-on-surface hover:bg-secondary hover:text-on-secondary transition-all shadow-sm" aria-label="{{ __('pagination.next') }}">
                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
            </a>
        @else
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-surface-container-low text-outline cursor-default" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
            </span>
        @endif
    </nav>
@endif
