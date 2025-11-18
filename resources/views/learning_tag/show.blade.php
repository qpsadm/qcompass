@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">学習コンテンツタグ詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>学習コンテンツID:</strong> {{ $LearningTag->learning_id }}</p>
            <p><strong>タグID:</strong> {{ $LearningTag->tag_id }}</p>
            <p><strong>削除日:</strong> {{ $LearningTag->deleted_at }}</p>

        </div>
        <a href="{{ route('learning_tag.edit', $LearningTag->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('learning_tag.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection
