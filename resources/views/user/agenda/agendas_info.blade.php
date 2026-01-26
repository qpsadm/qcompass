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
            $prevUrl = $prevAgenda ? route('user.agenda.info', $prevAgenda) : null;
            $nextUrl = $nextAgenda ? route('user.agenda.info', $nextAgenda) : null;
        @endphp

        <!-- ボタンリスト -->
        <x-f_btn_list :prevBtn="(bool) $prevAgenda" :nextBtn="(bool) $nextAgenda" :prevUrl="$prevUrl" :nextUrl="$nextUrl" :listBtn="true"
            listLabel="一覧へもどる" listUrl="{{ url('user/agendas') }}" />

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection
