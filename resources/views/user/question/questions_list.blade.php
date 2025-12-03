@extends('layouts.f_layout')

@section('title', '質疑応答一覧')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_qa.css') }}">
<style>
    .highlight {
        background-color: #ffff66;
        font-weight: bold;
        border-radius: 2px;
        padding: 0 2px;
    }
</style>
@endsection

@section('main-content')
<div class="container">

    {{-- f_page_title の検索フォームを活用 --}}
    <x-f_page_title
        :search="true"
        title="質疑応答一覧"
        :searchName="'keyword'"
        :searchPlaceholder="'キーワードで質疑応答検索'" />

    {{-- カテゴリーやタグのリスト --}}
    <x-f_category_list type="question" :tags="$tags" />

    {{-- ハイライト用関数 --}}
    @php
    $highlight = function($text) use ($keywords) {
    $text = e($text);
    foreach ($keywords as $word) {
    if (!$word) continue;
    $text = preg_replace(
    '/(' . preg_quote($word, '/') . ')/iu',
    '<span class="highlight">$1</span>',
    $text
    );
    }
    return $text;
    };
    @endphp

    {{-- 質疑応答一覧 --}}
    <div class="content-list">
        @foreach ($questions as $q)
        <div class="qa-accordion">
            <div class="question-container">
                <div class="question-icon"><span>Q</span></div>
                <div class="question-text">
                    <span>{!! $highlight($q->content) !!}</span>
                </div>
                <div class="accordion-btn"><span></span></div>
            </div>
            <div class="answer-container">
                <div class="answer-content">
                    <div class="answer-icon"><span>A</span></div>
                    <div class="answer-text">
                        <span>{!! $highlight($q->answer ?? '-') !!}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ページネーション --}}
    <x-f_pagination :paginator="$questions" />
    <x-f_bread_crumbs />
</div>
@endsection
