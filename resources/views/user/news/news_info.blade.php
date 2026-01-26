@extends('layouts.f_layout')

@section('title', $announcement->title)

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームなし） -->
        <x-f_page_title :search="false" title="{{ $announcement->title }}" />

        <!-- コンテンツ詳細（文字サイズ変更対象） -->
        <div
            class="page-content
            @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">
            <div>{!! $announcement->content !!}</div>
        </div>

        <!-- prev/nextボタン判定 -->
        @php
            $prevUrl = $prevAnnouncement
                ? route('user.news.news_info', ['announcement' => $prevAnnouncement->id])
                : null;
            $nextUrl = $nextAnnouncement
                ? route('user.news.news_info', ['announcement' => $nextAnnouncement->id])
                : null;
        @endphp

        <!-- ボタンリスト -->
        <x-f_btn_list :prevBtn="$prevAnnouncement !== null" :nextBtn="$nextAnnouncement !== null" :listBtn="true" :prevUrl="$prevUrl" :nextUrl="$nextUrl"
            listUrl="{{ route('user.news.news_list') }}" listLabel="一覧へもどる" />

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection
