@extends('layouts.f_layout')

@section('title', '質疑応答一覧')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_qa.css') }}">
@endsection

@section('main-content')
<div class="container">
    {{-- f_page_title の検索フォームを活用 --}}
    <x-f_page_title
        :search="true"
        title="質疑応答一覧"
        :searchName="'keyword'"
        :searchPlaceholder="'キーワードで求人検索'" />

    {{-- カテゴリーやタグのリストがあればここで表示 --}}
    <x-f_category_list type="question" :tags="$tags" />

    {{-- 質疑応答一覧 --}}
    <div class="content-list">

        {{-- ここから11/28 増井編集 --}}
        @foreach ($questions as $q)
        <div class="qa-accordion">
            <div class="question-container">
                <div class="question-icon">
                    <span>Q</span>
                </div>
                <div class="question-text">
                    <span>{{ $q->content }}</span>
                </div>
                <div class="accordion-btn">
                    <span></span>
                </div>
            </div>
            <div class="answer-container">
                <div class="answer-content">
                    <div class="answer-icon">
                        <span>A</span>
                    </div>
                    <div class="answer-text">
                        <span>{{ $q->answer ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{-- ここまで11/28 増井編集 --}}

    </div>

{{-- ページネーション --}}
    <x-f_pagination :paginator="$questions" />
    <x-f_bread_crumbs />

</div>
@endsection
