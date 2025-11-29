<div class="side-menu">
    <div class="side-menu-container">
        <div class="side-menu-top">
            <div class="site-logo">
                <a href="{{ route('user.top') }}"><img src="{{ asset('assets/images/f_site-logo.svg') }}"
                        alt="コンパスロゴ"></a>
            </div>

            <div class="contents-box">

                <div class="calendar">
                    <div class="calendar-data">
                        <div class="month"></div>
                        <div class="day"></div>
                        <span class="border"></span>
                        <div class="week"></div>
                    </div>
                </div>

                @foreach($courses as $course)
                <div class="course-item">
                    <div class="countdown">
                        <p class="countdown-title">修了まであと</p>
                        <div class="countdown-data">
                            <span class="data-number">{{ $course->remaining_days }}</span>
                            <span class="data-sub-title">日</span>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="today-short">
                    <p class="short-title">今日のひとこと</p>
                    <span class="short-text">我々は繰り返す事により形成される</span>
                    <span class="short-name">（アリストテレス）</span>
                </div>
            </div>

        </div>

        <div class="side-menu-bottom">
            <ul class="side-menu-list">
                <li><a class="calendar-list" href="../assets/images/f_pamphlet_test.pdf" target="_blank">日別計画表</a>
                </li>
                <li><a class="question" href="{{ route('user.question.questions_list') }}">質疑応答</a></li>
                <li><a class="report" href="{{ route('user.reports_create') }}">日報作成</a></li>
            </ul>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        ログアウト
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
