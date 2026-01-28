@extends('layouts.f_layout')

@section('title', $agenda->agenda_name)

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームなし） -->
        <x-f_page_title :search="false" title="{{ $agenda->agenda_name }}" />

        <!-- コンテンツ詳細（文字サイズ変更対象） -->
        <div
            class="page-content
            @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">
            <div>{!! $agenda->content !!}</div>
        </div>

        <!-- prev/nextボタン判定 -->
        @php
            $prevUrl = $prevAgenda ? route('user.job.job_dl_info', ['agenda' => $prevAgenda->id]) : null;
            $nextUrl = $nextAgenda ? route('user.job.job_dl_info', ['agenda' => $nextAgenda->id]) : null;
        @endphp

        <!-- ボタンリスト -->
        <x-f_btn_list :prevBtn="(bool) $prevAgenda" :nextBtn="(bool) $nextAgenda" :listBtn="true" :prevUrl="$prevUrl" :nextUrl="$nextUrl"
            listUrl="{{ url('user/job') }}" listLabel="一覧へもどる" />

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection
