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

        <!-- ボタンリスト -->
        <x-f_btn_list :prevBtn="false" :nextBtn="false" :listBtn="true" :prevUrl="null" :nextUrl="null"
            listUrl="{{ url('user/top') }}" listLabel="トップへもどる" />

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />
        
    </div>
@endsection
