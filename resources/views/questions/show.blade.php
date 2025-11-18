@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">質問詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>質問者ID:</strong> {{ $Question->asker_id }}</p>
            <p><strong>関連アジェンダID:</strong> {{ $Question->agenda_id }}</p>
            <p><strong>講座ID:</strong> {{ $Question->course_id }}</p>
            <p><strong>質問タイトル:</strong> {{ $Question->title }}</p>
            <p><strong>回答講師ID:</strong> {{ $Question->responder_id }}</p>
            <p><strong>質問内容:</strong> {{ $Question->content }}</p>
            <p><strong>回答内容:</strong> {{ $Question->answer }}</p>
            <p><strong>公開/非公開:</strong> {{ $Question->is_show }}</p>
            <p><strong>削除日:</strong> {{ $Question->deleted_at }}</p>

        </div>
        <a href="{{ route('questions.edit', $Question->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('questions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection
