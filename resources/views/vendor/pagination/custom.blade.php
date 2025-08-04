@if ($paginator->hasPages())
    <nav>
        <ul class="pagination  flex gap-[10px] ">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled dark:bg-[#111111] dark:border-[#808080] w-[2dvw] h-[4dvh] text-[2.5em] pb-[10px] flex justify-center items-center dark:border-[1px] rounded-[5px]" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true" class="dark:text-[#808080] ">&lsaquo;</span>
                </li>
            @else
                <li class="dark:bg-[#111111] dark:border-[#808080] w-[2dvw] h-[4dvh] text-[2.5em] pb-[10px] flex justify-center items-center dark:border-[1px] rounded-[5px]" >
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="dark:text-[#e3fc3d] " caria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled dark:bg-[#111111]  dark:border-[#808080] w-[3dvw] h-[5dvh] text-[4em] pb-[10px] flex justify-center items-center dark:border-[1px] rounded-[5px]" aria-disabled="true"><span class="dark:text-[#808080] ">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active dark:bg-[#111111] dark:border-[#808080] w-[2dvw] h-[4dvh] text-[2em]  flex justify-center items-center dark:border-[1px] rounded-[5px]" aria-current="page"><span class="dark:text-[#e3fc3d] ">{{ $page }}</span></li>
                        @else
                            <li class="dark:bg-[#111111] dark:border-[#808080] w-[2dvw] h-[4dvh] text-[2em]  flex justify-center items-center dark:border-[1px] rounded-[5px]"><a href="{{ $url }}" class="dark:text-[#808080] ">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="dark:bg-[#111111] dark:border-[#808080] w-[2dvw] h-[4dvh] text-[2.5em] pb-[10px] flex justify-center items-center dark:border-[1px] rounded-[5px]">
                    <a href="{{ $paginator->nextPageUrl() }}" class="dark:text-[#e3fc3d] " rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="disabled dark:bg-[#111111] dark:border-[#808080] w-[2dvw] h-[4dvh] text-[2.5em] pb-[10px] flex justify-center items-center dark:border-[1px] rounded-[5px]" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true" class="dark:text-[#808080] ">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
