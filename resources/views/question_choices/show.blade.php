@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">選択肢詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>紐づく設問ID:</strong> {{ $QuestionChoice->question_id }}</p>
            <p><strong>選択肢本文:</strong> {{ $QuestionChoice->choice_text }}</p>
            <p><strong>正解フラグ:</strong> {{ $QuestionChoice->is_correct }}</p>
            <p><strong>並び順:</strong> {{ $QuestionChoice->order }}</p>

        </div>
        <a href="{{ route('question_choices.edit', $QuestionChoice->id) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('question_choices.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection
