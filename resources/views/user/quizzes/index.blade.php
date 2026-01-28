@extends('layouts.f_layout')

@section('title', 'クイズ一覧')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_quiz.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームあり） -->
        <x-f_page_title :title="$selectedCategoryName ? 'クイズ一覧：' . $selectedCategoryName : 'クイズ一覧'" :search="false" />

        <!-- カテゴリ一覧 -->
        <x-f_category_accordion :categories="$categories" :selectedCategoryId="$selectedCategoryId" :routeFunction="fn($category) => $category
            ? route('user.quizzes.index', ['category_id' => $category->id])
            : route('user.quizzes.index')" />

        @foreach ($categories as $category)
            @php
                $categoryQuizzes = $quizzes->where('category_id', $category->id);
                $isActive = $selectedCategoryId === $category->id;
            @endphp

            @if ($categoryQuizzes->isNotEmpty())
                <div x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">

                    {{-- カテゴリ見出し --}}
                    <button type="button" @click="open = !open" class="quiz-category">
                        <span>{{ $category->name }}</span>
                        <span x-text="open ? '−' : '＋'"></span>
                    </button>

                    {{-- Accordion内にクイズ一覧 --}}
                    <div x-show="open" x-transition>
                        @foreach ($categoryQuizzes as $quiz)
                            <div class="quiz-container">
                                <h3 class="quiz-title">{{ $quiz->title }}【レベル：{{ $quiz->level }} 】</h3>

                                @if ($quiz->description)
                                    <p>{{ $quiz->description }}</p>
                                @endif

                                <div class="quiz-menu">
                                    <p class="quiz-count">問題数：{{ $quiz->questions_count }} 問</p>
                                    <a href="{{ route('user.quizzes.show', $quiz) }}" class="quiz-start">開始する</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        <!-- ページネーション -->
        <x-f_pagination :paginator="$quizzes" />

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection
