<header>
    <div class="header-container">
        <nav class="gnav">
            <ul>
                <li class="{{ request()->routeIs('user.top') ? 'active' : '' }}"><a class="home"
                        href="{{ route('user.top') }}">ホーム</a></li>
                <li class="{{ request()->routeIs('user.news.*') ? 'active' : '' }}"><a class="news"
                        href="{{ route('user.news.news_list') }}">お知らせ</a></li>
                <li class="{{ request()->routeIs('user.agenda.*') ? 'active' : '' }}"><a class="agenda"
                        href="{{ route('user.agenda.agendas_list') }}">アジェンダ</a></li>
                <li class="{{ request()->routeIs('user.question.*') ? 'active' : '' }}"><a class="study"
                        href="{{ route('user.question.questions_list') }}">学習支援</a></li>
                <li class="{{ request()->routeIs('user.job.*') ? 'active' : '' }}"><a class="work"
                        href="{{ route('user.job.job_offers_list') }}">就職支援</a></li>
                <li class="{{ request()->routeIs('user.mypage.*') ? 'active' : '' }}"><a class="mypage"
                        href="{{-- {{ route('user.mypage.mypage') }} --}}">マイページ</a></li>
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
            <div class="hamburger-container">
                <div class="hamburger-menu-left">
                    <div class="contents-box">

                        <div class="calendar">
                            <div class="calendar-data">
                                <div class="month"></div>
                                <div class="day"></div>
                                <span class="border"></span>
                                <div class="week"></div>
                            </div>
                        </div>

                        <div class="countdown">
                            <p class="countdown-title">修了まであと</p>
                            <div class="countdown-data">
                                <span class="data-number">108</span>
                                <span class="data-sub-title">日</span>
                            </div>
                        </div>

                        <div class="today-short">
                            <p class="short-title">今日のひとこと</p>
                            <span class="short-text">我々は繰り返す事により形成される</span>
                            <span class="short-name">（アリストテレス）</span>
                        </div>
                    </div>

                    <div class="logout-btn">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">
                                ログアウト
                            </button>
                        </form>
                    </div>
                </div>

                <div class="hamburger-menu-right">
                    <div class="side-menu-bottom">
                        <ul class="side-menu-list">
                            <li class="active"><a class="home" href="top.html">ホーム</a></li>
                            <li><a class="news" href="news/news_list_all.html">お知らせ</a></li>
                            <li><a class="agenda" href="agenda/agenda_list.html">アジェンダ</a></li>
                            <li><a class="study" href="study/study_qa_list.html">学習支援</a></li>
                            <li><a class="work" href="support/support_offer_list.html">就職支援</a></li>
                            <li><a class="mypage" href="mypage/mypage.html">マイページ</a></li>
                        </ul>
                    </div>
                    <div class="side-menu-bottom">
                        <ul class="side-menu-list">
                            <li><a class="calendar-list" href="../assets/images/f_pamphlet_test.pdf"
                                    target="_blank">日別計画表</a></li>
                            <li><a class="question" href="study/study_qa_list.html">質疑応答</a></li>
                            <li><a class="report" href="mypage/report.html">日報作成</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</header>
