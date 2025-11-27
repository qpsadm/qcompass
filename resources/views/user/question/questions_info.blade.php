@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <x-f_page_title :search="false" title="{{ $announcement->title }}" />

        <div class="page-content">
            <div>{!! $announcement->content !!}</div>
        </div>

        <x-f_btn_list :prevBtn="true" :listBtn="true" :nextBtn="true" listUrl="{{ url('user/question') }}"
            listLabel="一覧画面へ" />

        <x-f_bread_crumbs />
    </div>
@endsection
