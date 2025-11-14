@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">QuizAttempt詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>user_id:</strong> {{ $QuizAttempt->user_id }}</p>
<p><strong>quiz_id:</strong> {{ $QuizAttempt->quiz_id }}</p>
<p><strong>started_at:</strong> {{ $QuizAttempt->started_at }}</p>
<p><strong>completed_at:</strong> {{ $QuizAttempt->completed_at }}</p>
<p><strong>score:</strong> {{ $QuizAttempt->score }}</p>
<p><strong>status:</strong> {{ $QuizAttempt->status }}</p>
<p><strong>attempt_no:</strong> {{ $QuizAttempt->attempt_no }}</p>
<p><strong>ip_address:</strong> {{ $QuizAttempt->ip_address }}</p>

    </div>
    <a href="{{ route('quiz_attempts.edit', $QuizAttempt->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('quiz_attempts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection