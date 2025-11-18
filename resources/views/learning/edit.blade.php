@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">学習コンテンツ編集</h1>
        <form action="{{ route('learning.update', $Learning->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">種別</label>
                <input type="text" name="type" value="{{ old('type', $Learning->type ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">名前</label>
                <input type="text" name="name" value="{{ old('name', $Learning->name ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">著者名</label>
                <input type="text" name="author" value="{{ old('author', $Learning->author ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">出版社</label>
                <input type="text" name="publisher" value="{{ old('publisher', $Learning->publisher ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">出版日</label>
                <input type="date" name="publication_date"
                    value="{{ old('publication_date', $Learning->publication_date ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">ISBNコード</label>
                <input type="text" name="isbn" value="{{ old('isbn', $Learning->isbn ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">URL</label>
                <input type="text" name="url" value="{{ old('url', $Learning->url ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">画像</label>
                <input type="text" name="image" value="{{ old('image', $Learning->image ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">難易度</label>
                <input type="text" name="level" value="{{ old('level', $Learning->level ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">説明・備考</label>
                <input type="text" name="description" value="{{ old('description', $Learning->description ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">削除日</label>
                <input type="text" name="deleted_at" value="{{ old('deleted_at', $Learning->deleted_at ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
@endsection
