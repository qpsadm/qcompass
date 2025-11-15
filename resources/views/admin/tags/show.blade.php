@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">タグ詳細</h1>

    <div class="border p-4 rounded-lg mb-4 bg-white shadow-sm space-y-2">
        <p><strong>タグコード：</strong> {{ $Tag->code ?? '-' }}</p>
        <p><strong>タグ名：</strong> {{ $Tag->name ?? '-' }}</p>
        <p><strong>用途分類：</strong> {{ $Tag->tag_type ?? '-' }}</p>
        <p><strong>テーマカラー：</strong> {{ $Tag->theme_color ?? '-' }}</p>
        <p><strong>説明：</strong> {{ $Tag->description ?? '-' }}</p>
        <p><strong>削除日時：</strong> {{ $Tag->deleted_at ?? '-' }}</p>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('admin.tags.edit', $Tag->id) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            編集
        </a>
        <a href="{{ route('admin.tags.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            一覧に戻る
        </a>
    </div>
</div>
@endsection
