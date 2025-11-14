@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Achievement詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>title:</strong> {{ $Achievement->title }}</p>
<p><strong>description:</strong> {{ $Achievement->description }}</p>
<p><strong>condition_type:</strong> {{ $Achievement->condition_type }}</p>
<p><strong>condition_value:</strong> {{ $Achievement->condition_value }}</p>
<p><strong>deleted_at:</strong> {{ $Achievement->deleted_at }}</p>

    </div>
    <a href="{{ route('achievements.edit', $Achievement->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('achievements.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection