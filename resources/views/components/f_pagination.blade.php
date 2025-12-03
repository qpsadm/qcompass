@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="pagination">
        <ul>
            {{-- 前ページリンク --}}
            <li class="{{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                @if ($paginator->onFirstPage())
                    <span>«</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}">«</a>
                @endif
            </li>

            {{-- ページ番号リンク（省略対応） --}}
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);
            @endphp

            {{-- 先頭ページ --}}
            @if ($start > 1)
                <li><a href="{{ $paginator->url(1) }}">1</a></li>
                @if ($start > 2)
                    <li class="disabled"><span>…</span></li>
                @endif
            @endif

            {{-- 中央ページ --}}
            @for ($i = $start; $i <= $end; $i++)
                <li class="{{ $i == $current ? 'active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- 末尾ページ --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <li class="disabled"><span>…</span></li>
                @endif
                <li><a href="{{ $paginator->url($last) }}">{{ $last }}</a></li>
            @endif

            {{-- 次ページリンク --}}
            <li class="{{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}">»</a>
                @else
                    <span>»</span>
                @endif
            </li>
        </ul>
    </nav>
@endif
