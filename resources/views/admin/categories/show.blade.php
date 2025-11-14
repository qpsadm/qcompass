@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Category詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>code:</strong> {{ $Category->code }}</p>
            <p><strong>name:</strong> {{ $Category->name }}</p>
            <p><strong>parent_id:</strong> {{ $Category->parent_id }}</p>
            <p><strong>top_id:</strong> {{ $Category->top_id }}</p>
            <p><strong>level:</strong> {{ $Category->level }}</p>
            <p><strong>child_count:</strong> {{ $Category->child_count }}</p>
            <p><strong>is_show:</strong> {{ $Category->is_show }}</p>
            <p><strong>theme_color:</strong> {{ $Category->theme_color }}</p>
            <p><strong>deleted_at:</strong> {{ $Category->deleted_at }}</p>

        </div>
        <a href="{{ route('admin.categories.edit', $Category->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection
