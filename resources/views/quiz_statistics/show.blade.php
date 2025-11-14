@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">QuizStatistic詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>quiz_id:</strong> {{ $QuizStatistic->quiz_id }}</p>
<p><strong>average_score:</strong> {{ $QuizStatistic->average_score }}</p>
<p><strong>highest_score:</strong> {{ $QuizStatistic->highest_score }}</p>
<p><strong>attempts_count:</strong> {{ $QuizStatistic->attempts_count }}</p>

    </div>
    <a href="{{ route('quiz_statistics.edit', $QuizStatistic->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('quiz_statistics.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection