<header>
    <div class="header-container">
        <nav class="gnav">
            <ul>
                <li class="{{ request()->routeIs('user.top') ? 'active' : '' }}"><a class="home" href="{{ route('user.top') }}">ホーム</a></li>
                <li class="{{ request()->routeIs('user.news.*') ? 'active' : '' }}"><a class="news" href="{{ route('user.news.news_list') }}">お知らせ</a></li>
                <li class="{{ request()->routeIs('user.agenda.*') ? 'active' : '' }}"><a class="agenda" href="{{ route('user.agenda.agendas_list') }}">アジェンダ</a></li>
                <li class="{{ request()->routeIs('user.question.*') ? 'active' : '' }}"><a class="study" href="{{ route('user.question.questions_list') }}">学習支援</a></li>
                <li class="{{ request()->routeIs('user.job.*') ? 'active' : '' }}"><a class="work" href="{{-- {{ route('user.job.job_offers_list') }} --}}">就職支援</a></li>
                <li class="{{ request()->routeIs('user.mypage.*') ? 'active' : '' }}"><a class="mypage" href="{{-- {{ route('user.mypage.mypage') }} --}}">マイページ</a></li>
            </ul>
        </nav>

        <!-- responsive -->
        <div class="site-logo">
            <a href="{{ route('user.top') }}"><img src="{{ asset('assets/images/f_site-logo.svg') }}"
                    alt="コンパスロゴ"></a>
        </div>
        <div class="hamburger-btn">
            <span></span>
        </div>
        <div class="hamburger-menu">

        </div>
    </div>
</header>
