@extends('layouts.f_layout')

@section('title', 'マイページ')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_mypage.css') }}">
@endsection

@section('main-content')
<div class="container">
    <x-f_page_title :search="false" title="マイページ" />

    {{-- プロフィール --}}
    <div class="section-box profile">
        <div class="box-title">
            <h3>プロフィール</h3>
        </div>
        <div class="box-content">
            <div class="profile-icon">
                <img src="{{ asset('assets/images/f_profile-image.svg') }}" alt="">
            </div>
            <div class="profile-data">
                <h4>{{ $user->name }}</h4>
                <p class="mail">{{ $user->email }}</p>
                <p class="tel">{{ $user->phone ?? '未登録' }}</p>
                <p class="birthday">{{ $user_details->birthday ?? '未登録' }}</p>
            </div>
        </div>
    </div>

    {{-- 日報カレンダー --}}
    <div class="section-box calendar">
        <div class="box-title">
            <h3>日報カレンダー</h3>
        </div>
        <div class="box-content">
            <div id="calendar">
                @foreach($reports as $date)
                <div class="report-day">{{ $date }}</div>
                @endforeach
            </div>
            <p>※提出済みの日はチェックマークが表示されます。</p>
        </div>
    </div>

    {{-- 各種スケジュール／お知らせ --}}
    <div class="section-box">
        <div class="box-title">
            <h3>各種スケジュール</h3>
        </div>
        <div class="box-content">
            <x-f_content_list :items="$announcements" />
        </div>
    </div>

    {{-- メモ --}}
    <div class="section-box memo">
        <div class="box-title">
            <h3>メモ</h3>
        </div>
        <div class="box-content">

        </div>
    </div>

    {{-- パンくず --}}
    <div class="bread-crumbs">
        <ol>
            <li><a href="{{ route('user.top') }}">ホーム</a></li>
            <li>マイページ</li>
        </ol>
    </div>
</div>
@endsection
