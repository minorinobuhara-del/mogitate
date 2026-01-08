@if ($paginator->hasPages())
<nav class="pagination-wrapper">
    <ul class="pagination">

        {{-- 前のページ --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>‹</span></li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev">‹</a>
            </li>
        @endif

        {{-- ページ番号 --}}
        @foreach ($elements as $element)

            {{-- "..." --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- ページ配列 --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif

        @endforeach

        {{-- 次のページ --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next">›</a>
            </li>
        @else
            <li class="disabled"><span>›</span></li>
        @endif

    </ul>
</nav>
@endif
