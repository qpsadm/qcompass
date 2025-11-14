@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tag詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>code:</strong> {{ $Tag->code }}</p>
<p><strong>name:</strong> {{ $Tag->name }}</p>
<p><strong>tag_type:</strong> {{ $Tag->tag_type }}</p>
<p><strong>theme_color:</strong> {{ $Tag->theme_color }}</p>
<p><strong>description:</strong> {{ $Tag->description }}</p>
<p><strong>deleted_at:</strong> {{ $Tag->deleted_at }}</p>

    </div>
    <a href="{{ route('tags.edit', $Tag->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('tags.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection