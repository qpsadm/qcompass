@extends('layouts.f_layout')

@section('title', '質疑応答一覧')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_qa.css') }}">

@endsection

@section('main-content')
<div class="container">

    {{-- f_page_title の検索フォーム --}}
    <x-f_page_title
        :search="true"
        title="質疑応答一覧"
        :searchName="'keyword'"
        :searchPlaceholder="'キーワード検索'" />

    {{-- カテゴリーやタグのリスト --}}
    <x-f_category_list type="question" :tags="$tags" />

    {{-- ハイライト用関数 --}}
    @php
    $highlight = function($text) use ($keywords) {
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
        @forelse ($questions as $q)
        <div class="qa-accordion">
            <div class="question-container">
                <div class="question-icon"><span>Q</span></div>
                <div>
                    <span>{!! nl2br( $highlight($q->content)) !!}</span>
                </div>
                <div class="accordion-btn"><span></span></div>
            </div>
            <div class="answer-container">
                <div class="answer-content">
                    <div class="answer-icon"><span>A</span></div>
                    <div>
                        <span>{!! nl2br( $highlight($q->answer ?? '-')) !!}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500 py-4">
            該当する質疑応答はありません
        </div>
        @endforelse
    </div>

    {{-- ページネーション --}}
    <x-f_pagination :paginator="$questions" />
    <x-f_bread_crumbs />
</div>
@endsection
