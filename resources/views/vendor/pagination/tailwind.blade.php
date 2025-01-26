@if ($paginator->hasPages())
    <nav>
        <ul class="flex flex-wrap items-center justify-center gap-3">
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <li>
                    <a class="block p-3 text-teal-600 hover:text-teal-400 text-sm font-black leading-none" rel="prev">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="text-body/50 text-sm font-black leading-none" aria-disabled="true">
                        <span>{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page">
                                <span class="block p-3 pointer-events-none text-text-teal-600 text-sm font-black leading-none">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a class="block p-3 text-teal-600 hover:text-teal-400 text-sm font-black leading-none" href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="block p-3 text-teal-600 hover:text-teal-600 text-sm font-black leading-none"
                       href="{{ $paginator->nextPageUrl() }}"
                       rel="next"
                    >
                        &raquo;
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
