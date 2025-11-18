@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">解答詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>紐づく@auth
            受験履歴ID
        @endauth</strong> {{ $QuizAnswer->attempt_id }}</p>
<p><strong>設問ID:</strong> {{ $QuizAnswer->question_id }}</p>
<p><strong>選択肢ID:</strong> {{ $QuizAnswer->choice_id }}</p>
<p><strong>自由解答時の内容:</strong> {{ $QuizAnswer->answer_text }}</p>
<p><strong>正誤判定:</strong> {{ $QuizAnswer->is_correct }}</p>
<p><strong>採点後のスコア:</strong> {{ $QuizAnswer->score }}</p>

    </div>
    <a href="{{ route('quiz_answers.edit', $QuizAnswer->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('quiz_answers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection
