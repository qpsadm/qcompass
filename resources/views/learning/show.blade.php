@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">学習コンテンツ詳細</h1>
            <div class="border p-4 rounded mb-4">
                <p><strong>種別:</strong> {{ $Learning->type }}</p>
                <p><strong>タイトル:</strong> {{ $Learning->name }}</p>
                <p><strong>説明:</strong> {{ $Learning->author }}</p>
                <p><strong>画像:</strong> {{ $Learning->publisher }}</p>
                <p><strong>URL:</strong> {{ $Learning->publication_date }}</p>
                <p><strong>レベル:</strong> {{ $Learning->isbn }}</p>
                <p><strong>タグID:</strong> {{ $Learning->url }}</p>
                <p><strong>表示フラグ:</strong> {{ $Learning->image }}</p>
                <p><strong>作成日時:</strong> {{ $Learning->level }}</p>
                <p><strong>作成者名:</strong> {{ $Learning->description }}</p>
                <p><strong>更新日時:</strong> {{ $Learning->description }}</p>
                <p><strong>更新者名:</strong> {{ $Learning->description }}</p>
                <p><strong>削除日時:</strong> {{ $Learning->description }}</p>
                <p><strong>削除者名:</strong> {{ $Learning->deleted_at }}</p>

            </div>
            <a href="{{ route('learning.edit', $Learning->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('learning.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
        </div>
    @endsection
