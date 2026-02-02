@extends('layouts.f_layout')

@section('title', $quiz->title)

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_quiz.css') }}">
@endsection

@section('main-content')
<div class="container">

    <!-- ページタイトル（検索フォームなし） -->
    <x-f_page_title :search="false" title="クイズ [{{ $quiz->title }}]" />

    <!-- コンテンツ詳細（文字サイズ変更対象） -->
    <form
        class="quiz-form
            @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch"
        method="POST" action="{{ route('user.quizzes.submit', $quiz) }}">
        @csrf

        @foreach ($questions as $index => $question)
        <div class="question-container">
            <h2 class="question-number">
                問題 {{ $index + 1 }}（{{ $question->score }}点）
            </h2>
            <p class="question-title">{!! nl2br(htmlspecialchars($question->question_text)) !!}</p>


            <!-- 単一選択（2択・4択） -->
            @if (in_array($question->type, ['single_2', 'single_4']))
            @foreach ($question->choices as $choice)
            <div class="question-select">
                <input type="radio" id="choice_{{ $choice->id }}" name="answers[{{ $question->id }}]"
                    value="{{ $choice->id }}" style="appearance:auto;">
                <label for="choice_{{ $choice->id }}">
                    {{ $choice->choice_text }}
                </label>
            </div>
            @endforeach

            <!-- 複数選択 -->
            @elseif ($question->type === 'multi')
            @foreach ($question->choices as $choice)
            <div class="question-select">
                <input type="checkbox" id="choice_{{ $choice->id }}"
                    name="answers[{{ $question->id }}][]" value="{{ $choice->id }}"
                    style="appearance:auto;">
                <label for="choice_{{ $choice->id }}">
                    {{ $choice->choice_text }}
                </label>
            </div>
            @endforeach

            <!-- 記述式 -->
            @elseif ($question->type === 'text')
            <div class="question-select">
                <textarea name="answers[{{ $question->id }}]" rows="3" placeholder="回答を入力してください"></textarea>
            </div>
            @endif

        </div>
        @endforeach

        <button type="submit" class="submit-btn">
            回答する
        </button>

        <a href="{{ route('user.quizzes.index') }}" class="back-btn">
            一覧へもどる
        </a>
    </form>

    <!-- パンくずリスト -->
    <x-f_bread_crumbs />

</div>
@endsection
