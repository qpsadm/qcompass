@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <x-f_page_title :search="false" title="{{ $announcement->title }}" />
        {{-- <h1>{{ $announcement->title }}</h1> --}}
        {{-- <p>講座: {{ $announcement->course?->name ?? '全講座' }}</p>
        <p>カテゴリー: {{ $announcement->type?->name ?? '未分類' }}</p> --}}
        <div class="page-content">
            <div>{!! $announcement->content !!}</div>
        </div>

        <x-f_btn_list :prevBtn="true" :listBtn="true" :nextBtn="true" listUrl="" listLabel="新着情報一覧へ" />

        <x-f_bread_crumbs />
    </div>
@endsection
