<div class="page-title">
    <h2>{{ $title }}</h2>
    @if ($search)
    <div class="search">
        <form method="GET" action="{{ route('user.agenda.agendas_list') }}">
            <div class="search-container">
                <input class="search-text" type="text" name="search" placeholder="キーワード検索" value="{{ request('search') }}">
                <input class="search-submit" type="submit" value="">
            </div>
        </form>
    </div>
    @endif
</div>
