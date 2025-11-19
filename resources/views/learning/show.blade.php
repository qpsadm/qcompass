@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">学習コンテンツ詳細</h1>
            <div class="border p-4 rounded mb-4">
                <p><strong>種別:</strong> {{ $Learning->type }}</p>
                <p><strong>名前:</strong> {{ $Learning->name }}</p>
                <p><strong>著者名:</strong> {{ $Learning->author }}</p>
                <p><strong>出版社:</strong> {{ $Learning->publisher }}</p>
                <p><strong>出版日:</strong> {{ $Learning->publication_date }}</p>
                <p><strong>ISBNコード:</strong> {{ $Learning->isbn }}</p>
                <p><strong>URL:</strong> {{ $Learning->url }}</p>
                <p><strong>画像:</strong> {{ $Learning->image }}</p>
                <p><strong>難易度:</strong> {{ $Learning->level }}</p>
                <p><strong>説明・備考:</strong> {{ $Learning->description }}</p>
                <p><strong>削除日:</strong> {{ $Learning->deleted_at }}</p>

            </div>
            <a href="{{ route('learning.edit', $Learning->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('learning.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
        </div>
    @endsection
