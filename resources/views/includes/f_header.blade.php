<header>
    <div class="header-container">
        <nav class="gnav">
            <ul>
                <li class="active"><a class="home" href="{{ route('user.dashboard') }}">ホーム</a></li>
                <li><a class="news" href="{{ route('user.news.news_list') }}">お知らせ</a></li>
                <li><a class="agenda" href="{{ route('user.agenda.agenda_list') }}">アジェンダ</a></li>
                <li><a class="study" href="{{ route('user.questions.questions_list') }}">学習支援</a></li>
                <li><a class="work" href="{{ route('user.job.job_offers_list') }}">就職支援</a></li>
                <li><a class="mypage" href="{{ route('user.mypage.mypage') }}">マイページ</a></li>
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
