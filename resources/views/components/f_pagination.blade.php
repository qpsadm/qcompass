@props(['paginator'])
<nav class="pagination">
    <ul id="pagination-list">
        {{-- 前のページリンク --}}
        <li class="prev {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            @if (!$paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}"></a>
            @else
                <span></span>
            @endif
        </li>

        {{-- ページ番号リンク --}}
        @foreach ($paginator->links()->elements as $element)
            @if (is_string($element))
                <li class="dots"><span>{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}"
                        data-page="{{ $page }}" data-url="{{ $url }}">
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
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

<script>
    function updatePagination() {
        const allPages = document.querySelectorAll('#pagination-list .page-item');
        const currentPage = Array.from(allPages).findIndex(li => li.classList.contains('active')) + 1;
        const totalPages = allPages.length;

        const isMobile = window.innerWidth < 768; // ブレークポイント
        const range = isMobile ? 1 : 2; // 前後表示ページ数

        allPages.forEach((li, idx) => {
            const page = idx + 1;
            li.style.display = 'none'; // 一旦全部非表示
        });

        // 現在ページ前後を表示
        for (let i = currentPage - range; i <= currentPage + range; i++) {
            if (i >= 1 && i <= totalPages) {
                allPages[i - 1].style.display = 'inline-block';
            }
        }

        // 先頭と末尾は常に表示
        allPages[0].style.display = 'inline-block';
        allPages[totalPages - 1].style.display = 'inline-block';

        // ドットを挿入
        document.querySelectorAll('#pagination-list .dots').forEach(d => d.remove());

        // 先頭～現在-範囲
        if (currentPage - range > 2) {
            const dot = document.createElement('li');
            dot.className = 'dots';
            dot.innerHTML = '<span>…</span>';
            allPages[0].after(dot);
        }

        // 現在+範囲～末尾
        if (currentPage + range < totalPages - 1) {
            const dot = document.createElement('li');
            dot.className = 'dots';
            dot.innerHTML = '<span>…</span>';
            allPages[totalPages - 2].after(dot);
        }
    }

    // 初回とリサイズ時に更新
    updatePagination();
    window.addEventListener('resize', updatePagination);
</script>
