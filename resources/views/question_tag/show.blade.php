@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">質問タグ詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>質問ID:</strong> {{ $QuestionTag->question_id }}</p>
            <p><strong>タグID:</strong> {{ $QuestionTag->tag_id }}</p>
            <p><strong>削除日:</strong> {{ $QuestionTag->deleted_at }}</p>

        </div>
        <a href="{{ route('question_tag.edit', $QuestionTag->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('question_tag.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection
