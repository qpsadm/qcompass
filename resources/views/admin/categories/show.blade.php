@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">カテゴリー詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>コード:</strong> {{ $Category->code }}</p>
            <p><strong>カテゴリー名:</strong> {{ $Category->name }}</p>
            <p><strong>親ID:</strong> {{ $Category->parent_id }}</p>
            <p><strong>最上位ID:</strong> {{ $Category->top_id }}</p>
            <p><strong>階層:</strong> {{ $Category->level }}</p>
            <p><strong>子数:</strong> {{ $Category->child_count }}</p>
            <p><strong>表示/非表示:</strong> {{ $Category->is_show }}</p>
            <p><strong>削除日:</strong> {{ $Category->deleted_at }}</p>

        </div>
        <a href="{{ route('admin.categories.edit', $Category->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection
