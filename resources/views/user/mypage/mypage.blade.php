@extends('layouts.f_layout')

@section('title', 'マイページ')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_mypage.css') }}">
@endsection

@section('main-content')
<div class="container">

    {{-- プロフィールモーダル --}}
    <div class="modal-profile">
        <div class="profile-data">
            <h4>{{ $user->name }}</h4>
            <p class="mail">{{ $user->email ?? '未登録' }}</p>
            <p class="tel">{{ $user_details?->phone1 ?? '未登録' }}</p>
            <p class="birthday">{{ $user_details?->birthday ? $user_details->birthday->format('Y/m/d') : '未登録' }}</p>

            <div class="btn-area">
                <button class="close-btn">とじる</button>
            </div>
        </div>
    </div>

    {{-- カスタマイズモーダル --}}
    <div class="modal-customize">
        <form action="{{ route('user.settings.update') }}" method="POST">
            @csrf
            @php
            $initialTheme = $user->detail->theme_id ?? 1;
            @endphp

            {{-- テーマカラー選択 --}}
            <div class="theme-color-select">
                <p>テーマカラー</p>
                <div class="radio-container">
                    @foreach ($themes as $theme)
                    <input type="radio" id="theme-{{ $theme->id }}" name="theme_id" value="{{ $theme->id }}"
                        {{ $initialTheme == $theme->id ? 'checked' : '' }}>
                    <label for="theme-{{ $theme->id }}">{{ $theme->name }}</label>
                    @endforeach
                </div>
            </div>

            {{-- フォントサイズ選択 --}}
            <div class="font-size-select">
                <label for="">フォントサイズ</label>
                <div class="radio-container">
                    <input type="radio" id="small" name="fontsize" value="1"
                        {{ ($user_details->fontsize ?? 2) == 1 ? 'checked' : '' }}>
                    <label for="small">標準</label>

                    <input type="radio" id="medium" name="fontsize" value="2"
                        {{ ($user_details->fontsize ?? 2) == 2 ? 'checked' : '' }}>
                    <label for="medium">中</label>

                    <input type="radio" id="large" name="fontsize" value="3"
                        {{ ($user_details->fontsize ?? 2) == 3 ? 'checked' : '' }}>
                    <label for="large">大</label>
                </div>
                <p class="note">※フォントサイズの変更は、各ページの詳細画面および日報作成フォーム内にのみ適用されます。</p>
            </div>

            <div class="btn-area">
                <button class="close-btn">変更する</button>
            </div>
        </form>

        <div class="btn-area">
            <button class="close-btn">とじる</button>
        </div>
    </div>

    <div class="overlay"></div>

    {{-- ページタイトル --}}
    <x-f_page_title :search="false" title="マイページ" />

    {{-- プロフィール・カレンダー --}}
    <div class="section-flex">
        <div class="section-box profile">
            <div class="box-title">
                <h3>プロフィール</h3>
            </div>
            <div class="box-content">
                <div class="profile-icon">
                    <img src="{{ $user_details && $user_details->avatar_path
                            ? asset('storage/' . $user_details->avatar_path)
                            : asset('assets/images/f_profile-image.svg') }}"
                        alt="プロフィール画像">
                </div>
                <div class="profile-data">
                    <h4>{{ $user->name }}</h4>
                    <p class="mail">{{ $user->email ?? '未登録' }}</p>
                    <p class="course">{{ $courses->pluck('course_name')->join(' / ') ?: '未設定' }}</p>
                    <p class="division">{{ $divisions->name ?? '未設定' }}</p>
                    <p class="division-tel">（{{ $divisions->tel ?? '未設定' }}）</p>

                    <div class="btn-area">
                        <button class="open-btn-profile">プロフィールをみる</button>
                        <button class="open-btn-customize">カスタマイズ</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-box calendar">
            <div class="box-title">
                <h3>日報カレンダー</h3>
            </div>
            <div class="box-content">
                <div id="calendar"></div>
                <p>※日報を提出した日はチェックマークが表示されます。<br>提出し忘れていないかチェックしましょう。</p>
            </div>
        </div>
    </div>

    {{-- 各種スケジュール --}}
    <div class="section-box">
        <div class="box-title">
            <h3>各種スケジュール</h3>
        </div>
        <div class="box-content">
            <x-f_content_list :items="$scheduledAnnouncements" />
        </div>
    </div>


    {{-- メモ --}}
    <div class="section-box memo">
        <div class="box-title">
            <h3>メモ</h3>
        </div>
        <div class="box-content">
            <form id="memo-form" class="memo-form" method="POST">
                @csrf
                <textarea name="memo" id="memo-textarea" rows="6">{{ $user_details->memo ?? '' }}</textarea>
                <button type="submit">保存</button>
            </form>
            <div id="memo-success" style="display:none; color: green; margin-top: 5px;">
                メモを保存しました
            </div>
        </div>
    </div>

    <x-f_bread_crumbs />

</div>
@endsection

@section('code-page-js')
<script src="{{ asset('assets/js/f_mypage.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // -------------------------
        // テーマカラー管理
        // -------------------------
        let savedTheme = localStorage.getItem('theme_id') || '{{ $initialTheme }}';
        document.body.className = 'theme-' + savedTheme;

        const radios = document.querySelectorAll('input[name="theme_id"]');
        radios.forEach(radio => {
            radio.checked = radio.value === savedTheme;
            radio.addEventListener('change', function() {
                document.body.className = 'theme-' + this.value;
                localStorage.setItem('theme_id', this.value);

                fetch('/api/set-theme', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        theme_id: this.value
                    })
                });
            });
        });

        // -------------------------
        // FullCalendar初期化
        // -------------------------
        var calendarEl = document.getElementById('calendar');

        var pendingEvents = [
            @foreach($pending_diaries as $diary) {
                title: '',
                start: '{{ $diary->date }}',
                allDay: true,
                backgroundColor: 'transparent',
                borderColor: 'transparent',
                extendedProps: {
                    isPending: true,
                    url: '{!! $diary->url !!}'
                }
            },
            @endforeach
        ];

        var submittedEvents = [
            @foreach($submitted_reports as $report) {
                title: '',
                start: '{{ \Carbon\Carbon::parse($report->date)->format("Y-m-d") }}',
                allDay: true,
                backgroundColor: 'transparent',
                borderColor: 'transparent',
                extendedProps: {
                    isPending: false,
                    url: '{{ route("user.reports_info", ["report" => $report->id]) }}'
                }
            },
            @endforeach
        ];


        window.APP_URL = "{{ url('/') }}";

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ja',
            timeZone: "Asia/Tokyo",

            dayCellContent: function(arg) {
                return arg.date.getDate();
            },

            events: pendingEvents.concat(submittedEvents),

            eventContent: function(arg) {
                if (arg.event.extendedProps.isPending) return {
                    domNodes: []
                };
                const img = document.createElement('img');
                img.src = `${window.APP_URL}/assets/images/icon/f_icon_check_on.svg`;
                img.alt = "提出済";
                img.style.width = "40px";
                img.style.height = "40px";
                img.style.cursor = "pointer";
                return {
                    domNodes: [img]
                };
            },

            eventClick: function(info) {
                if (info.event.extendedProps.url) {
                    window.location.href = info.event.extendedProps.url;
                }
            },

            dateClick: function(info) {
                var event = calendar.getEvents().find(event => event.startStr === info.dateStr &&
                    event.extendedProps.url);
                if (event) window.location.href = event.extendedProps.url;
            },

            datesSet: function() {
                document.querySelectorAll('.fc-daygrid-day-frame').forEach(frame => {
                    const date = frame.parentElement.getAttribute('data-date');
                    var hasEvent = calendar.getEvents().some(event => event.startStr ===
                        date && event.extendedProps.url);

                    frame.style.cursor = hasEvent ? 'pointer' : 'default';
                    if (hasEvent) {
                        frame.addEventListener('mouseenter', function() {
                            frame.style.backgroundColor = '#fff9c4';
                        });
                        frame.addEventListener('mouseleave', function() {
                            frame.style.backgroundColor = '';
                        });
                    }
                });
            }
        });

        calendar.render();

        // -------------------------
        // メモ保存
        // -------------------------
        $('#memo-form').on('submit', function(e) {
            e.preventDefault();
            const memo = $('#memo-textarea').val();
            const token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('user.memo.save') }}",
                type: 'POST',
                data: {
                    _token: token,
                    memo: memo
                },
                success: function() {
                    $('#memo-success').fadeIn().delay(2000).fadeOut();
                },
                error: function() {
                    alert('保存に失敗しました');
                }
            });
        });
    });
</script>
@endsection
