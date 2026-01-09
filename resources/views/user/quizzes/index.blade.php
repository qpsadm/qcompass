@extends('layouts.f_layout')

@section('title', 'クイズ一覧')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_quiz.css') }}">
@endsection

@section('main-content')
<div class="container">

    <x-f_page_title title="クイズ一覧" :search="false" />

    {{-- =========================
        カテゴリありクイズ
    ========================= --}}
    @foreach ($categories as $category)
    @if ($category->quizzes->isNotEmpty())
    <section class="quiz-category mb-10">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">
            {{ $category->name }}
        </h2>

        @foreach ($category->quizzes as $quiz)
        <div class="quiz-container mb-4">
            <h3 class="quiz-title">
                {{ $quiz->title }}
            </h3>

            @if ($quiz->description)
            <p class="text-gray-600 text-sm mb-2">
                {{ $quiz->description }}
            </p>
            @endif

            <div class="quiz-menu">
                <p class="quiz-count">
                    問題数：{{ $quiz->questions_count }} 問
                </p>

                <a href="{{ route('user.quizzes.show', $quiz) }}"
                    class="quiz-start">
                    開始する
                </a>
            </div>
        </div>
        @endforeach
    </section>
    @endif
    @endforeach

    {{-- =========================
        未分類クイズ
    ========================= --}}
    @if ($uncategorizedQuizzes->isNotEmpty())
    <section class="quiz-category mb-10">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">
            その他のクイズ
        </h2>

        @foreach ($uncategorizedQuizzes as $quiz)
        <div class="quiz-container mb-4">
            <h3 class="quiz-title">
                {{ $quiz->title }}
            </h3>

            @if ($quiz->description)
            <p class="text-gray-600 text-sm mb-2">
                {{ $quiz->description }}
            </p>
            @endif

            <div class="quiz-menu">
                <p class="quiz-count">
                    問題数：{{ $quiz->questions_count }} 問
                </p>

                <a href="{{ route('user.quizzes.show', $quiz) }}"
                    class="quiz-start">
                    開始する
                </a>
            </div>
        </div>
        @endforeach
    </section>
    @endif

    {{-- =========================
        クイズが0件のとき
    ========================= --}}
    @php
    $hasQuiz =
    $categories->contains(fn($c) => $c->quizzes->isNotEmpty())
    || $uncategorizedQuizzes->isNotEmpty();
    @endphp

    @if (!$hasQuiz)
    <p class="text-center text-gray-500 mt-10">
        表示できるクイズはありません
    </p>
    @endif

    <x-f_bread_crumbs />

</div>
@endsection
