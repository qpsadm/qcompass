@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">QuizAnswer詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>attempt_id:</strong> {{ $QuizAnswer->attempt_id }}</p>
<p><strong>question_id:</strong> {{ $QuizAnswer->question_id }}</p>
<p><strong>choice_id:</strong> {{ $QuizAnswer->choice_id }}</p>
<p><strong>answer_text:</strong> {{ $QuizAnswer->answer_text }}</p>
<p><strong>is_correct:</strong> {{ $QuizAnswer->is_correct }}</p>
<p><strong>score:</strong> {{ $QuizAnswer->score }}</p>

    </div>
    <a href="{{ route('quiz_answers.edit', $QuizAnswer->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('quiz_answers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection