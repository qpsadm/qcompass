<div class="page-title">
    <h1>{{ $title }}</h1>

    @if ($search)
    <div class="search">
        <form method="GET" action="{{ $searchAction ?? url()->current() }}">
            <div class="search-container">
                <input
                    class="search-text"
                    type="text"
                    name="{{ $searchName ?? 'search' }}"
                    placeholder="{{ $searchPlaceholder ?? 'キーワード検索' }}"
                    value="{{ request($searchName ?? 'search') }}">
                <input class="search-submit" type="submit" value="">
            </div>
        </form>
    </div>
    @endif
</div>
