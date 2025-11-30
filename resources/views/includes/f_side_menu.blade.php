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

                    @if(!empty($todayQuote))
                    <div class="short-text">
                        @if($quote_mode === 'mix' && Session::has('quote_parts'))
                        @foreach(Session::get('quote_parts') as $part)
                        {{ $part->text }}
                        @endforeach
                        @else
                        {{ $todayQuote->quote_full }}
                        @endif
                    </div>

                    <div class="short-name">
                        （
                        @if($quote_mode === 'mix' && Session::has('author_parts'))
                        @foreach(Session::get('author_parts') as $part)
                        {{ $part->text }}
                        @endforeach
                        @else
                        {{ $todayQuote->author_full ?? '作者不明' }}
                        @endif
                        ）
                        <button class="inline-toggle" data-mode="{{ $quote_mode === 'full' ? 'mix' : 'full' }}" onclick="toggleQuoteMode(event)">?</button>
                    </div>


                    @else
                    <span class="short-text">名言が登録されていません</span>
                    @endif
                </div>

                <form id="quote-mode-form" method="POST" action="{{ route('user.quote_mode') }}" style="display:none;">
                    @csrf
                    <input type="hidden" name="mode" value="">
                </form>

                <script>
                    function toggleQuoteMode(event) {
                        event.preventDefault();
                        const mode = event.currentTarget.getAttribute('data-mode');
                        document.querySelector('#quote-mode-form input[name="mode"]').value = mode;
                        document.getElementById('quote-mode-form').submit();
                    }
                </script>



            </div>

        </div>

        <div class="side-menu-bottom">
            <ul class="side-menu-list">
                @foreach($courses as $course)
                @if($course->plan_path)
                <li>
                    <a class="calendar-list" href="{{ asset($course->plan_path) }}" target="_blank">
                        日別計画表
                    </a>
                </li>
                @endif
                @endforeach
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
