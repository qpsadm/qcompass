<header>
    <div class="header-container">
        <nav class="gnav">
            <ul>
                <li class="main-menu {{ request()->routeIs('user.top') ? 'active' : '' }}"><a class="home"
                        href="{{ route('user.top') }}">ホーム</a></li>
                <li class="main-menu {{ request()->routeIs('user.news.*') ? 'active' : '' }}"><a class="news"
                        href="{{ route('user.news.news_list') }}">お知らせ</a></li>
                <li class="main-menu {{ request()->routeIs('user.agenda.*') ? 'active' : '' }}"><a class="agenda"
                        href="{{ route('user.agenda.agendas_list') }}">アジェンダ</a></li>
                <li
                    class="main-menu menu-study {{ request()->routeIs('user.question.*', 'user.quizzes.*') ? 'active' : '' }}">
                    <a class="study" href="{{ route('user.quizzes.index') }}">学習支援</a>
                    <ul class="gnav-sub">
                        <li class="{{ request()->routeIs('user.quizzes.*') ? 'active' : '' }}">
                            <a href="{{ route('user.quizzes.index') }}">クイズ</a>
                        </li>
                        <li><a href="{{ route('user.learnings.learnings_by_type', ['type' => 4]) }}">制作品紹介</a></li>
                        <li><a href="{{ route('user.learnings.learnings_by_type', ['type' => 3]) }}">IT資格</a></li>
                        <li><a href="{{ route('user.learnings.learnings_by_type', ['type' => 1]) }}">参考書籍</a></li>
                        <li><a href="{{ route('user.learnings.learnings_by_type', ['type' => 2]) }}">参考サイト</a></li>

                    </ul>
                </li>
                <li class="main-menu {{ request()->routeIs('user.job.*') ? 'active' : '' }}"><a class="work"
                        href="{{ route('user.job.job_offers_list') }}">就職支援</a></li>

                <li class="main-menu {{ request()->routeIs('user.mypage') ? 'active' : '' }}">
                    <a class="mypage" href="{{ route('user.mypage') }}">マイページ</a>
                </li>

            </ul>
        </nav>

        <!-- responsive -->
        <div class="site-logo">
            <a href="{{ route('user.top') }}"><img src="{{ asset('assets/images/logo_star.svg') }}"
                    alt="コンパスロゴ"></a>
        </div>
        <div class="hamburger-btn">
            <span></span>
        </div>
        <div class="hamburger-menu">
            <div class="hamburger-container">
                <div class="hamburger-menu-left">
                    <div class="contents-box">

                        <div class="calendar @if ($isBirthday) birthday-effect @endif">
                            <div class="calendar-data">
                                <div class="month">{{ now()->format('m') }}</div>
                                <div class="day">{{ now()->format('d') }}</div>
                                <span class="border"></span>
                                <div class="week">{{ strtoupper(now()->format('D')) }}</div>
                            </div>

                        </div>

                        @forelse ($courses ?? [] as $course)
                        <div class="course-item">
                            <div class="countdown">
                                <p class="countdown-title">修了まであと</p>
                                <div class="countdown-data">
                                    <span class="data-number">{{ $course->remaining_days }}</span>
                                    <span class="data-sub-title">日</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <span>受講中の講座はありません</span>
                        @endforelse
                        <div class="today-short">
                            <p class="short-title">今日のひとこと</p>

                            @if (!empty($todayQuote))
                            <div class="short-text">
                                @if ($quote_mode === 'mix' && is_array(session('mix_quote_parts', [])))
                                @foreach (session('mix_quote_parts', []) as $part)
                                {{ $part->text ?? $part }}
                                @endforeach
                                @else
                                {{ $todayQuote->quote_full }}
                                @endif
                            </div>

                            <div class="short-name">
                                -
                                @if ($quote_mode === 'mix' && is_array(session('mix_author_parts', [])))
                                @foreach (session('mix_author_parts', []) as $part)
                                {{ $part->text ?? $part }}
                                @endforeach
                                @else
                                {{ $todayQuote->author_full ?? '作者不明' }}
                                @endif
                                -
                            </div>
                            @else
                            <span class="short-text">名言が登録されていません</span>
                            @endif
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
                            <li><a class="home" href="{{ route('user.top') }}">ホーム</a></li>
                            <li><a class="news" href="{{ route('user.news.news_list') }}">お知らせ</a></li>
                            <li><a class="agenda" href="{{ route('user.agenda.agendas_list') }}">アジェンダ</a></li>
                            <li><a class="study" href="{{ route('user.quizzes.index') }}">学習支援</a></li>
                            <ul>
                                <li class="{{ request()->routeIs('user.quizzes.*') ? 'active' : '' }}"><a
                                        href="{{ route('user.quizzes.index') }}">クイズ</a></li>
                                <li><a href="{{ route('user.learnings.learnings_by_type', ['type' => 4]) }}">制作品紹介</a></li>
                                <li><a href="{{ route('user.learnings.learnings_by_type', ['type' => 3]) }}">IT資格</a></li>
                                <li><a href="{{ route('user.learnings.learnings_by_type', ['type' => 1]) }}">参考書籍</a></li>
                                <li><a href="{{ route('user.learnings.learnings_by_type', ['type' => 2]) }}">参考サイト</a></li>

                            </ul>
                            {{-- <li><a class="work" href="{{ route('user.job.job_offers_list') }}">就職支援</a></li>
                            <li><a class="mypage" href="{{ route('user.mypage') }}">マイページ</a></li> --}}
                        </ul>
                    </div>
                    <div class="side-menu-bottom">
                        <ul class="side-menu-list">
                            <li><a class="work" href="{{ route('user.job.job_offers_list') }}">就職支援</a></li>
                            <li><a class="mypage" href="{{ route('user.mypage') }}">マイページ</a></li>
                            <li><a class="report" href="{{ route('user.reports_create') }}">日報作成</a></li>
                            @foreach ($courses as $course)
                            @if ($course->plan_path)
                            <li>
                                <a class="calendar-list" href="{{ asset('storage/' . $course->plan_path) }}"
                                    target="_blank">
                                    日別計画表
                                </a>
                            </li>
                            @endif
                            @endforeach
                            <li><a class="question" href="{{ route('user.question.questions_list') }}">質疑応答</a></li>


                        </ul>
                    </div>
                </div>
            </div>
        </div>
</header>
