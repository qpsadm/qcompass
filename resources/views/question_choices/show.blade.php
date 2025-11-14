@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">QuestionChoice詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>question_id:</strong> {{ $QuestionChoice->question_id }}</p>
<p><strong>choice_text:</strong> {{ $QuestionChoice->choice_text }}</p>
<p><strong>is_correct:</strong> {{ $QuestionChoice->is_correct }}</p>
<p><strong>order:</strong> {{ $QuestionChoice->order }}</p>

    </div>
    <a href="{{ route('question_choices.edit', $QuestionChoice->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('question_choices.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection