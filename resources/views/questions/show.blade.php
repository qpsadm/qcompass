@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Question詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>asker_id:</strong> {{ $Question->asker_id }}</p>
<p><strong>agenda_id:</strong> {{ $Question->agenda_id }}</p>
<p><strong>course_id:</strong> {{ $Question->course_id }}</p>
<p><strong>title:</strong> {{ $Question->title }}</p>
<p><strong>responder_id:</strong> {{ $Question->responder_id }}</p>
<p><strong>content:</strong> {{ $Question->content }}</p>
<p><strong>answer:</strong> {{ $Question->answer }}</p>
<p><strong>is_show:</strong> {{ $Question->is_show }}</p>
<p><strong>deleted_at:</strong> {{ $Question->deleted_at }}</p>

    </div>
    <a href="{{ route('questions.edit', $Question->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('questions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection