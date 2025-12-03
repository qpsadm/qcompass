@props(['paginator'])

<nav class="pagination">
    <ul>
        {{-- 前のページリンク --}}
        <li class="prev {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            @if ($paginator->onFirstPage())
            @else
                <a href="{{ $paginator->previousPageUrl() }}"></a>
            @endif
        </li>

        {{-- ページ番号リンク --}}
        @foreach ($paginator->links()->elements as $element)
            {{-- "..." の場合 --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- 配列の場合 --}}
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

        {{-- 次のページリンク --}}
        <li class="next {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"></a>
            @else
            @endif
        </li>
    </ul>
</nav>
