@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <x-f_page_title :search="false" title="{{ $announcement->title }}" />

            <div class="page-content
@switch(session('settings.fontsize', 2))
@case(1)@break
@case(2) font-medium @break
@case(3) font-large @break
@endswitch">
            <div>{!! $announcement->content !!}</div>
        </div>

        <x-f_btn_list :prevBtn="true" :listBtn="true" :nextBtn="true" listUrl="{{ url('user/job') }}"
            listLabel="一覧画面へ" />

        <x-f_bread_crumbs />
    </div>
@endsection
