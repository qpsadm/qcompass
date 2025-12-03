<div class="side-menu">
    <div class="side-menu-container">
        <div class="side-menu-top">
            <div class="site-logo">
                <a href="{{ route('user.top') }}">
                    <img src="{{ asset('assets/images/logo_star.svg') }}" alt="コンパスロゴ">
                </a>
            </div>

            <div class="contents-box">

                <div class="calendar">
                    <div class="calendar-data">
                        <div class="month">{{ now()->format('m') }}</div>
                        <div class="day">{{ now()->format('d') }}</div>
                        <span class="border"></span>
                        <div class="week">{{ strtoupper(now()->format('D')) }}</div>
                    </div>
                </div>

                @forelse ($courses as $course)
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
                    <p>受講中の講座はありません</p>
                @endforelse

                <div class="today-short">
                    <p class="short-title">今日のひとこと</p>

                    @if (!empty($todayQuote))
                        <div class="short-text {{ $quote_mode === 'mix' ? 'mix-mode' : 'full-mode' }}">
                            @if ($quote_mode === 'mix' && session('mix_quote_parts'))
                                @foreach (session('mix_quote_parts') as $text)
                                    {{ $text }}
                                @endforeach
                            @else
                                {{ $todayQuote->quote_full }}
                            @endif
                        </div>

                        <div class="short-name {{ $quote_mode === 'mix' ? 'mix-mode' : 'full-mode' }}">
                            -
                            @if ($quote_mode === 'mix' && session('mix_author_parts'))
                                @foreach (session('mix_author_parts') as $text)
                                    {{ $text }}
                                @endforeach
                            @else
                                {{ $todayQuote->author_full ?? '作者不明' }}
                            @endif
                            -
                            {{-- <button class="inline-toggle" data-mode="{{ $quote_mode === 'full' ? 'mix' : 'full' }}"
                                onclick="toggleQuoteMode(event);">.</button> --}}
                        </div>
                    @else
                        <span class="short-text">名言が登録されていません</span>
                    @endif
                </div>

                <form id="quote-mode-form" method="POST" action="{{ route('user.quote_mode') }}"
                    style="display:none;">
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
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
            </div>
        </div>
    </div>
</div>
