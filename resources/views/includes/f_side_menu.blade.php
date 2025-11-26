<div class="side-menu">
    <div class="side-menu-container">
        <div class="side-menu-top">
            <div class="site-logo">
                <a href=""><img src="{{ asset('assets/images/f_site-logo.svg') }}" alt=""></a>
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

        </div>

        <div class="side-menu-bottom">
            <ul class="side-menu-list">
                <li><a class="calendar-list" href="../assets/images/f_pamphlet_test.pdf" target="_blank">日別計画表</a>
                </li>
                <li><a class="question" href="study/study_qa_list.html">質疑応答</a></li>
                <li><a class="report" href="mypage/report.html">日報作成</a></li>
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
