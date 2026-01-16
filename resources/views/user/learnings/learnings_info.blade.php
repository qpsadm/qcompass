@extends('layouts.f_layout')

@section('title', $learning->title)

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
<div class="container">

    {{-- ページタイトル --}}
    <x-f_page_title :search="false" title="{{ $learning->title }}" />

    {{-- 学習リソース内容 --}}
    <div class="page-content
        @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">

        {{-- 説明 --}}
        <div>{!! $learning->description !!}</div>

        {{-- 画像表示 --}}
        @if ($learning->image)
        <div class="mt-4">
            <img src="{{ asset('storage/' . $learning->image) }}" alt="{{ $learning->title }}" class="max-w-full h-auto rounded">
        </div>
        @endif

        {{-- PDF/URLリンク --}}
        <div class="mt-4 space-x-2">
            @if ($learning->url)
            <a href="{{ $learning->url }}" target="_blank" class="btn btn-primary">外部リンクを開く</a>
            @endif

            @if ($learning->file_path ?? false)
            <a href="{{ asset('storage/learnings/' . basename($learning->file_path)) }}" target="_blank" class="btn btn-primary">
                PDF を開く
            </a>
            @endif
        </div>

        {{-- レベル表示 --}}
        <div class="mt-2 text-sm text-gray-600">
            レベル:
            @if($learning->level == 1) 初級
            @elseif($learning->level == 2) 中級
            @elseif($learning->level == 3) 上級
            @else 未設定
            @endif
        </div>

        {{-- タグ --}}
        @if($learning->tag)
        <div class="mt-1 text-sm text-gray-500">
            タグ: {{ $learning->tag->name }}
        </div>
        @endif

    </div>

    {{-- 前後ボタン --}}
    @php
    $prevUrl = $prevLearning ?? null ? route('user.learnings.info', ['learning' => $prevLearning->id]) : null;
    $nextUrl = $nextLearning ?? null ? route('user.learnings.info', ['learning' => $nextLearning->id]) : null;
    @endphp

    <x-f_btn_list
        :prevBtn="(bool)$prevLearning"
        :nextBtn="(bool)$nextLearning"
        :prevUrl="$prevUrl"
        :nextUrl="$nextUrl"
        :listBtn="true"
        listUrl="{{ route('user.learnings.list') }}"
        listLabel="一覧へもどる" />

    {{-- パンくず --}}
    <x-f_bread_crumbs />

</div>
@endsection
