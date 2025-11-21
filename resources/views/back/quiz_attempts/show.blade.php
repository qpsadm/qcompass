@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">受験履歴詳細</h1>
            <div class="border p-4 rounded mb-4">
                <p><strong>user_id:</strong> {{ $QuizAttempt->user_id }}</p>
                <p><strong>クイズID:</strong> {{ $QuizAttempt->quiz_id }}</p>
                <p><strong>開始時刻:</strong> {{ $QuizAttempt->started_at }}</p>
                <p><strong>終了時刻:</strong> {{ $QuizAttempt->completed_at }}</p>
                <p><strong>得点:</strong> {{ $QuizAttempt->score }}</p>
                <p><strong>状態:</strong> {{ $QuizAttempt->status }}</p>
                <p><strong>受験回数:</strong> {{ $QuizAttempt->attempt_no }}</p>
                <p><strong>受験環境記録※任意※:</strong> {{ $QuizAttempt->ip_address }}</p>

            </div>
            <a href="{{ route('quiz_attempts.edit', $QuizAttempt->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('quiz_attempts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
        </div>
    @endsection
