@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">タグ詳細</h1>

            <div class="border p-4 rounded-lg mb-4 bg-white shadow-sm space-y-2">
                <p><strong>タグコード：</strong> {{ $Tag->code ?? '-' }}</p>
                <p><strong>タグ名：</strong> {{ $Tag->name ?? '-' }}</p>
                <p><strong>表示フラグ：</strong> {{ $Tag->is_show ? '表示' : '非表示' }}</p>
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
    </div>
@endsection
