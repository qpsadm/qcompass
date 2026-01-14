@extends('layouts.f_layout')

@section('title', 'クイズ一覧')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_quiz.css') }}">
@endsection

@section('main-content')
<div class="container">

    <x-f_page_title
        :title="$selectedCategoryName
        ? 'クイズ一覧：' . $selectedCategoryName
        : 'クイズ一覧'"
        :search="false" />

    <x-f_category_accordion
        :categories="$categories"
        :selectedCategoryId="$selectedCategoryId"
        :routeFunction="fn($category) =>
        $category
            ? route('user.quizzes.index', ['category_id' => $category->id])
            : route('user.quizzes.index')
    " />



    @foreach($categories as $category)
    @php
    $categoryQuizzes = $quizzes->where('category_id', $category->id);
    $isActive = $selectedCategoryId === $category->id;
    @endphp

    @if($categoryQuizzes->isNotEmpty())
    <div x-data="{ open: {{ $isActive ? 'true' : 'false' }} }" class="mb-4">

        {{-- カテゴリ見出し --}}
        <button
            type="button"
            @click="open = !open"
            class="w-full flex justify-between items-center quiz-category cursor-pointer px-4 py-2 bg-gray-200 rounded">
            <span>{{ $category->name }}</span>
            <span x-text="open ? '−' : '＋'"></span>
        </button>

        {{-- Accordion内にクイズ一覧 --}}
        <div x-show="open" x-transition class="mt-2">
            @foreach($categoryQuizzes as $quiz)
            <div class="quiz-container mb-3 p-3 border rounded bg-white">
                <h3 class="quiz-title">{{ $quiz->title }}【レベル：{{ $quiz->level }} 】</h3>

                @if ($quiz->description)
                <p class="text-gray-600 text-sm mb-2">{{ $quiz->description }}</p>
                @endif

                <div class="quiz-menu flex justify-between items-center">
                    <p class="quiz-count">問題数：{{ $quiz->questions_count }} 問</p>
                    <a href="{{ route('user.quizzes.show', $quiz) }}" class="quiz-start px-4 py-2 bg-blue-500 text-white rounded">開始する</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endforeach


    <x-f_pagination :paginator="$quizzes" />

    <x-f_bread_crumbs />

</div>
@endsection
