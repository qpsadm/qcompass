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

        {{-- <table class="table">
                <thead>
                    <tr>
                        <th>質問タイトル</th>
                        <th>質問内容</th>
                        <th>回答</th>
                        <th>アジェンダ</th>
                        <th>講座</th>
                        <th>タグ</th>
                        <th>回答者</th>
                        <th>作成日</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $q)
                        <tr>
                            <td>{{ $q->title }}</td>
        <td>{{ $q->content }}</td>
        <td>{{ $q->answer ?? '-' }}</td>
        <td>{{ $q->agenda?->agenda_name ?? '-' }}</td>
        <td>{{ $q->course?->course_name ?? '-' }}</td>
        <td>{{ $q->tag?->name ?? '-' }}</td>
        <td>{{ $q->responder?->name ?? '-' }}</td>
        <td>{{ $q->created_at->format('Y/m/d') }}</td>
        </tr>
        @endforeach
        </tbody>

        </table> --}}

        {{-- ここから11/28 増井編集 --}}
        @foreach ($questions as $q)
        <div class="qa-accordion">
            <div class="question-container">
                <div class="question-icon">
                    <span>Q</span>
                </div>
                <div class="question-text">
                    <td>{{ $q->content }}</td>
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
                        <td>{{ $q->answer ?? '-' }}</td>
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

@if ($lastPage >= 1)
<nav class="pagination w-full flex justify-center mt-6 mb-6">
    <ul class="flex flex-wrap justify-center gap-2">
        {{-- 前へ --}}
        <li class="prev">
            @if ($prevPage)
                <a href="{{ $questions->url($prevPage) }}" class="px-3 py-1 border rounded hover:bg-gray-200 text-[18px]">‹</a>
            @else
                <span class="px-3 py-1 border rounded text-gray-400 text-[18px]">‹</span>
            @endif
        </li>

        {{-- ページ番号 --}}
        @for ($i = 1; $i <= $lastPage; $i++)
            <li class="{{ $i == $currentPage ? 'active' : '' }}">
                @if ($i == $currentPage)
                    <span class="px-3 py-1 bg-blue-500 text-white rounded shadow text-[18px]">{{ $i }}</span>
                @else
                    <a href="{{ $questions->url($i) }}" class="px-3 py-1 border rounded hover:bg-gray-200 text-[18px]">{{ $i }}</a>
                @endif
            </li>
        @endfor

        {{-- 次へ --}}
        <li class="next">
            @if ($nextPage)
                <a href="{{ $questions->url($nextPage) }}" class="px-3 py-1 border rounded hover:bg-gray-200 text-[18px]">›</a>
            @else
                <span class="px-3 py-1 border rounded text-gray-400 text-[18px]">›</span>
            @endif
        </li>
    </ul>
</nav>
@endif

</div>
@endsection

