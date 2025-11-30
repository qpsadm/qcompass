@extends('layouts.f_layout')

@section('title', 'マイページ')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_mypage.css') }}">
@endsection

@section('main-content')
<div class="container">
    <x-f_page_title :search="false" title="マイページ" />

    <div class="section-flex">
        <div class="section-box profile">
            <div class="box-title">
                <h3>プロフィール</h3>
            </div>
            <div class="box-content">
                <div class="profile-icon">
                    <img src="{{ $user_details && $user_details->profile_image
                            ? asset('storage/' . $user_details->profile_image)
                            : asset('assets/images/f_profile-image.svg') }}"
                        alt="プロフィール画像">
                </div>
                <div class="profile-data">
                    <h4>{{ $user->name }}</h4>
                    <p class="mail">
                        {{ $user->email ?? '未登録' }}
                    </p>
                    <p class="tel">
                        {{ $user_details?->phone1 ?? '未登録' }}
                    </p>
                    <p class="birthday">
                        {{ $user_details?->birthday?->format('Y-m-d') ?? '未登録' }}
                    </p>
                </div>

                <div class="btn-area">
                    <a href="">テーマカラー変更</a>
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
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
        });
        calendar.render();
    });
</script>
@endsection
