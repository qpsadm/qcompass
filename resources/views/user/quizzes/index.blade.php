@extends('layouts.f_layout')

@section('title', 'クイズ一覧')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_quiz.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <x-f_page_title :search="false" title="クイズ一覧" />

        @forelse($quizzes as $quiz)
            <div class="quiz-container">
                <h2 class="quiz-title">{{ $quiz->title }}</h2>
                <p class="text-gray-600">{{ $quiz->description }}</p>
                <div class="quiz-menu">
                    <p class="quiz-count">
                        問題数: {{ $quiz->questions_count }}
                    </p>
                    <a href="{{ route('user.quizzes.show', $quiz->id) }}" class="quiz-start">
                        開始する
                    </a>
                </div>
            </div>
        @empty
            <p>表示できるクイズはありません</p>
        @endforelse

        <x-f_bread_crumbs />
    </div>
@endsection
