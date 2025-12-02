@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
    <div class="container">

        @php
$prevUrl = $prevAnnouncement ? route('user.news.news_info', ['announcement' => $prevAnnouncement->id]) : null;
$nextUrl = $nextAnnouncement ? route('user.news.news_info', ['announcement' => $nextAnnouncement->id]) : null;

        @endphp


        <x-f_page_title :search="false" title="{{ $announcement->title }}" />

            <div class="page-content
@switch(session('settings.fontsize', 2))
@case(1)@break
@case(2) font-medium @break
@case(3) font-large @break
@endswitch">
                <div>{!! $announcement->content !!}</div>
            </div>


<x-f_btn_list
            :prevBtn="true"
            :listBtn="true"
            :nextBtn="true"
            listUrl="{{ url('user/news') }}"
            listLabel="新着情報一覧へ"

            :prevUrl="$prevUrl"
            :nextUrl="$nextUrl"
        />

        <x-f_bread_crumbs />
    </div>
@endsection
