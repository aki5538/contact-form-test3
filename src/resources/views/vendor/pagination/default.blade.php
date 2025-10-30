@if ($paginator->hasPages())
    <nav class="simple-pagination">
        {{-- ＜ 前へ --}}
        @if ($paginator->onFirstPage())
            <span class="arrow disabled">＜</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="arrow">＜</a>
        @endif

        {{-- ページ番号 --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- 次へ ＞ --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="arrow">＞</a>
        @else
            <span class="arrow disabled">＞</span>
        @endif
    </nav>
@endif


