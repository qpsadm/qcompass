@extends('layouts.f_layout')

@section('title', 'マイページ')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_mypage.css') }}">
@endsection

@section('main-content')
<div class="container">

    <div class="modal-profile">
        <div class="profile-data">
            <h4>{{ $user->name }}</h4>
            <p class="mail">{{ $user->email ?? '未登録'}}</p>
            <p class="tel">{{ $user_details?->phone1 ?? '未登録' }}</p>
            <p class="birthday">{{ $user_details?->birthday ? $user_details->birthday->format('Y/m/d') : '未登録' }}</p>

            <div class="btn-area">
                <button class="close-btn" href="">とじる</button>
            </div>
        </div>
    </div>

    <div class="modal-customize">
        <div class="profile-data">
            <h4>カスタマイズ</h4>
            <p class="mail">{{ $user->email ?? '未登録'}}</p>
            <p class="tel">{{ $user_details?->phone1 ?? '未登録' }}</p>
            <p class="birthday">{{ $user_details?->birthday ? $user_details->birthday->format('Y/m/d') : '未登録' }}</p>

            <div class="btn-area">
                <button class="close-btn" href="">とじる</button>
            </div>
        </div>
    </div>


    <div class="overlay"></div>

    <x-f_page_title :search="false" title="マイページ" />

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
                    <p class="mail">
                        {{ $user->email ?? '未登録'}}
                    </p>
                    <p class="tel">
                        {{ $user_details?->phone1 ?? '未登録' }}
                    </p>
                    <p class="birthday">
                        {{ $user_details?->birthday ? $user_details->birthday->format('Y/m/d') : '未登録' }}
                    </p>

                    <p>所属部署：{{ $divisions->name ?? '未設定' }}</p>

                    <div class="btn-area">
                        <button class="open-btn-profile" href="">プロフィールをみる</button>
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
                <div id='calendar'></div>
                <p>※日報を提出した日はチェックマークが表示されます。<br>
                    提出し忘れていないかチェックしましょう。</p>
            </div>

        </div>
    </div>

    <div class="section-box">
        <div class="box-title">
            <h3>各種スケジュール</h3>
        </div>
        <div class="box-content">
            {{-- <div class="content-list">
                    <table>
                        <tr>
                            <td class="category">
                                <p class="course-all">日直</p>
                            </td>
                            <td class="title"><a href="">日直のスケジュール</a></td>
                        </tr>
                        <tr>
                            <td class="category">
                                <p class="course-all">日直</p>
                            </td>
                            <td class="title"><a href="">清掃・Facebook投稿のスケジュール</a></td>
                        </tr>
                        <tr>
                            <td class="category">
                                <p class="course-all">日直</p>
                            </td>
                            <td class="title"><a href="">第1回朝礼のテーマについて</a></td>
                        </tr>
                    </table>
                </div> --}}

            <x-f_content_list :items="$announcements" />
        </div>
    </div>

    <div class="section-box memo">
        <div class="box-title">
            <h3>メモ</h3>
        </div>
        <div class="box-content">
            <form class="memo-form" action="">
                <textarea name="" id="" rows="6"></textarea>
                <button>保存</button>
            </form>
        </div>
    </div>

    <div class="bread-crumbs">
        <ol>
            <li><a href="">ホーム</a></li>
            <li><a href="">マイページ</a></li>
        </ol>
    </div>
</div>
@endsection

@section('code-page-js')
<script src="{{ asset('assets/js/f_mypage.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        var calendarEl = document.getElementById('calendar');

        var pendingEvents = [
            @foreach($pending_diaries as $diary) {
                title: '', // 赤丸だけ表示
                start: '{{ $diary->date }}',
                allDay: true,
                backgroundColor: 'transparent', // 背景透明
                borderColor: 'transparent', // 枠線透明
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
        return arg.date.getDate(); // ← 「日」を消して数字だけにする
    },

    events: pendingEvents.concat(submittedEvents),

    eventContent: function(arg) {
        if (arg.event.extendedProps.isPending) {
            return { domNodes: [] }; // 未提出はアイコン非表示
        }

        // 提出済みはアイコン表示
        const img = document.createElement('img');
        img.src = `${window.APP_URL}/assets/images/icon/f_icon_check_on.svg`;
        img.alt = "提出済";
        img.style.width = "40px";
        img.style.height = "40px";
        img.style.cursor = "pointer";

        return { domNodes: [img] };
    },

    // 画像クリック / 提出済みイベントクリック
    eventClick: function(info) {
        if (info.event.extendedProps.url) {
            window.location.href = info.event.extendedProps.url;
        }
    },

    // 日付セルクリック
    dateClick: function(info) {
        // その日付のイベントをすべて検索
        var event = calendar.getEvents().find(event => {
            return event.startStr === info.dateStr && event.extendedProps.url;
        });

        if (event) {
            window.location.href = event.extendedProps.url;
        }
    },

    // 日付セルのカーソルとホバー色設定
    datesSet: function() {
        document.querySelectorAll('.fc-daygrid-day-frame').forEach(frame => {
            const date = frame.parentElement.getAttribute('data-date');

            var hasEvent = calendar.getEvents().some(event => {
                return event.startStr === date && event.extendedProps.url;
            });

            // 未提出・提出済みのセルだけ pointer
            frame.style.cursor = hasEvent ? 'pointer' : 'default';

            // ホバー時に薄い黄色にする
            if (hasEvent) {
                frame.addEventListener('mouseenter', function() {
                    frame.style.backgroundColor = '#fff9c4'; // 薄い黄色
                });
                frame.addEventListener('mouseleave', function() {
                    frame.style.backgroundColor = '';
                });
            }
        });
    }
});


        calendar.render();
    });
</script>

@endsection
