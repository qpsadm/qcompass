@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Learning詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>type:</strong> {{ $Learning->type }}</p>
<p><strong>name:</strong> {{ $Learning->name }}</p>
<p><strong>author:</strong> {{ $Learning->author }}</p>
<p><strong>publisher:</strong> {{ $Learning->publisher }}</p>
<p><strong>publication_date:</strong> {{ $Learning->publication_date }}</p>
<p><strong>isbn:</strong> {{ $Learning->isbn }}</p>
<p><strong>url:</strong> {{ $Learning->url }}</p>
<p><strong>image:</strong> {{ $Learning->image }}</p>
<p><strong>level:</strong> {{ $Learning->level }}</p>
<p><strong>description:</strong> {{ $Learning->description }}</p>
<p><strong>deleted_at:</strong> {{ $Learning->deleted_at }}</p>

    </div>
    <a href="{{ route('learning.edit', $Learning->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('learning.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection