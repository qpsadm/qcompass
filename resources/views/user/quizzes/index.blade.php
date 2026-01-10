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




    {{-- ▼ クイズ一覧 --}}
    <div class="content-list">

        @forelse ($quizzes as $quiz)
        <div class="quiz-container">
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
        @empty
        <p class="text-center text-gray-500 mt-10">
            表示できるクイズはありません
        </p>
        @endforelse

    </div>

    <x-f_pagination :paginator="$quizzes" />

    <x-f_bread_crumbs />

</div>
@endsection
