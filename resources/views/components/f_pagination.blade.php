@props(['paginator'])

@if ($paginator->hasPages())
<nav class="pagination">
    <ul>
        {{-- 前のページリンク --}}
        <li class="prev {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            @if ($paginator->onFirstPage())
            <span></span>
            @else
            <a href="{{ $paginator->previousPageUrl() }}"></a>
            @endif
        </li>

        {{-- ページ番号リンク --}}
        @foreach ($paginator->links()->elements[0] as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="active"><span>{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach

        {{-- 次のページリンク --}}
        <li class="next {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
            @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"></a>
            @else
            <span></span>
            @endif
        </li>
    </ul>
</nav>
@endif
