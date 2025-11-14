@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Quiz詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>code:</strong> {{ $Quiz->code }}</p>
<p><strong>title:</strong> {{ $Quiz->title }}</p>
<p><strong>description:</strong> {{ $Quiz->description }}</p>
<p><strong>course_id:</strong> {{ $Quiz->course_id }}</p>
<p><strong>agenda_id:</strong> {{ $Quiz->agenda_id }}</p>
<p><strong>type:</strong> {{ $Quiz->type }}</p>
<p><strong>time_limit:</strong> {{ $Quiz->time_limit }}</p>
<p><strong>total_score:</strong> {{ $Quiz->total_score }}</p>
<p><strong>passing_score:</strong> {{ $Quiz->passing_score }}</p>
<p><strong>random_order:</strong> {{ $Quiz->random_order }}</p>
<p><strong>active_from:</strong> {{ $Quiz->active_from }}</p>
<p><strong>active_to:</strong> {{ $Quiz->active_to }}</p>
<p><strong>created_by:</strong> {{ $Quiz->created_by }}</p>
<p><strong>deleted_at:</strong> {{ $Quiz->deleted_at }}</p>

    </div>
    <a href="{{ route('quizzes.edit', $Quiz->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('quizzes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection