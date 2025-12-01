@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">

        {{-- 白いカード枠 --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">学習コンテンツ編集</h1>

            <form action="{{ route('admin.learnings.update', $learning->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- 種別 --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">種類</label>
                    <select name="type" class="border px-2 py-1 w-full">
                        <option value="book" {{ $learning->type === 'book' ? 'selected' : '' }}>本</option>
                        <option value="site" {{ $learning->type === 'site' ? 'selected' : '' }}>サイト</option>
                        <option value="video" {{ $learning->type === 'video' ? 'selected' : '' }}>動画</option>
                        <option value="article" {{ $learning->type === 'article' ? 'selected' : '' }}>記事</option>
                    </select>
                    @error('type')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- タイトル --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">タイトル</label>
                    <input type="text" name="title" class="border px-2 py-1 w-full"
                        value="{{ old('title', $learning->title) }}">
                    @error('title')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 説明 --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">説明</label>
                    <textarea name="description" class="border px-2 py-1 w-full">{{ old('description', $learning->description) }}</textarea>
                </div>

                {{-- 画像URL --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">画像URL</label>
                    <input type="text" name="image" class="border px-2 py-1 w-full"
                        value="{{ old('image', $learning->image) }}">
                </div>

                {{-- リンクURL --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">リンクURL</label>
                    <input type="text" name="url" class="border px-2 py-1 w-full"
                        value="{{ old('url', $learning->url) }}">
                </div>

                {{-- レベル --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">レベル</label>
                    <select name="level" class="border px-2 py-1 w-full">
                        <option value="1" {{ $learning->level == 1 ? 'selected' : '' }}>初級</option>
                        <option value="2" {{ $learning->level == 2 ? 'selected' : '' }}>上級</option>
                    </select>
                </div>

                {{-- タグ（ラジオボタン） --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">タグ</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($tags as $tag)
                            <div>
                                <input type="radio" name="tag_id" value="{{ $tag->id }}"
                                    {{ old('tag_id', $learning->tag_id) == $tag->id ? 'checked' : '' }}
                                    id="tag-{{ $tag->id }}">
                                <label for="tag-{{ $tag->id }}" class="ml-2">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('tag_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 表示フラグ --}}
 <div class="mb-4" x-data="{ is_show: {{ old('is_show', $learning->is_show ?? 0) }} }">
    <span class="font-medium mr-2">表示フラグ</span>
    <div class="flex gap-2">
        <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
            <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
            公開
        </label>

        <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
            <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
            非公開
        </label>
    </div>
</div>


                {{-- 更新ボタン --}}
                <div class="flex items-center space-x-3 mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新</button>
                    <a href="{{ route('admin.learnings.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>

    </div>
@endsection
