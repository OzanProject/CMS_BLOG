@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="d-flex justify-content-center mt-5">
        <ul class="pagination-premium">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link-premium"><i class="fa fa-angle-left"></i> {{ __('Kembali') }}</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link-premium" rel="prev"><i class="fa fa-angle-left"></i> {{ __('Kembali') }}</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link-premium dots">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link-premium">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link-premium">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link-premium" rel="next">{{ __('Lanjut') }} <i class="fa fa-angle-right"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link-premium">{{ __('Lanjut') }} <i class="fa fa-angle-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .pagination-premium {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 10px;
            align-items: center;
        }
        .page-link-premium {
            display: inline-block;
            padding: 10px 18px;
            background: #fff;
            color: #334155;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .page-item.active .page-link-premium {
            background: #007bff; /* Primary Blue */
            color: #fff;
            border-color: #007bff;
            box-shadow: 0 10px 15px -3px rgba(0, 123, 255, 0.3);
            transform: translateY(-2px);
        }
        .page-item:not(.active):not(.disabled) .page-link-premium:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
            color: #007bff;
        }
        .page-item.disabled .page-link-premium {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            box-shadow: none;
        }
        .pagination-premium .dots {
            border: none;
            box-shadow: none;
            background: transparent;
        }
        @media (max-width: 576px) {
            .page-link-premium {
                padding: 8px 12px;
                font-size: 13px;
            }
            .pagination-premium {
                gap: 5px;
            }
        }
    </style>
@endif
