@extends('layouts.f_layout')

@section('title', '質疑応答一覧')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_qa.css') }}">
@endsection

@section('main-content')
<div class="container">
    <x-f_page_title :search="true" title="質疑応答一覧" />

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
@php
    $lastPage = $questions->lastPage();
    $currentPage = $questions->currentPage();
    $prevPage = $currentPage > 1 ? $currentPage - 1 : null;
    $nextPage = $currentPage < $lastPage ? $currentPage + 1 : null;
@endphp

<nav class="pagination w-full flex justify-center mt-6 mb-6">
    <ul class="flex flex-wrap justify-center gap-2 items-center">

        {{-- 前へ --}}
        <li>
            @if ($prevPage)

                <a href="{{ $questions->url($prevPage) }}" class="px-3 py-1 rounded text-orange-500 hover:text-orange-600 text-[18px]">&#x25C0;</a>
            @else

                <span class="px-3 py-1 rounded text-orange-300 text-[18px] cursor-not-allowed">&#x25C0;</span>
            @endif
        </li>

        {{-- ページ番号 --}}
        @for ($i = 1; $i <= $lastPage; $i++)
            <li>
                @if ($i == $currentPage)

                    <span class="px-3 py-1 bg-blue-500 text-white rounded">{{ $i }}</span>
                @else

                    <a href="{{ $questions->url($i) }}" class="px-3 py-1 border rounded hover:bg-gray-200 text-[18px]">{{ $i }}</a>
                @endif
            </li>
        @endfor

        {{-- 次へ --}}
        <li>
            @if ($nextPage)

                <a href="{{ $questions->url($nextPage) }}" class="px-3 py-1 rounded text-orange-500 hover:text-orange-600 text-[18px]">
                    &#x25B6;
                </a>
            @else

                <span class="px-3 py-1 rounded text-orange-300 text-[18px] cursor-not-allowed">
                    &#x25B6;
                </span>
            @endif
        </li>

    </ul>
</nav>

</div>
@endsection
