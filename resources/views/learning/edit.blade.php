@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">学習コンテンツ編集</h1>

        {{-- エラー表示 --}}
        @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.learnings.update', $learning->id) }}" method="POST">
            @csrf
            @method('PUT')

            @php
            // 種別
            $types = [
            'book' => '1. 本',
            'site' => '2. サイト',
            'video' => '3. 動画',
            'article' => '4. 記事',
            ];

            // レベル
            $levels = [
            1 => '初級',
            2 => '上級',
            ];

            // タグ（固定）
            $fixedTags = [
            1 => 'WEB制作 (0)',
            2 => 'WEBデザイン (0)',
            3 => 'プログラミング (0)',
            4 => 'OA (0)',
            5 => 'その他 (0)',
            ];
            @endphp

            {{-- 種別 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">種類</label>
                <select name="type" class="border px-3 py-2 w-full rounded">
                    @foreach ($types as $value => $label)
                    <option value="{{ $value }}"
                        {{ old('type', $learning->type) === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- タイトル --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">タイトル</label>
                <input
                    type="text"
                    name="title"
                    class="border px-3 py-2 w-full rounded"
                    value="{{ old('title', $learning->title) }}">
            </div>

            {{-- 説明 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">説明・備考</label>
                <textarea
                    name="description"
                    rows="3"
                    class="border px-3 py-2 w-full rounded">{{ old('description', $learning->description) }}</textarea>
            </div>

            {{-- 画像URL --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">画像URL</label>
                <input
                    type="text"
                    name="image"
                    class="border px-3 py-2 w-full rounded"
                    value="{{ old('image', $learning->image) }}">
            </div>

            {{-- リンクURL --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">リンクURL</label>
                <input
                    type="text"
                    name="url"
                    class="border px-3 py-2 w-full rounded"
                    value="{{ old('url', $learning->url) }}">
            </div>

            {{-- レベル --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">レベル</label>
                <select name="level" class="border px-3 py-2 w-full rounded">
                    <option value="">選択してください</option>
                    @foreach ($levels as $value => $label)
                    <option value="{{ $value }}"
                        {{ old('level', $learning->level) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- タグ --}}
            <div class="mb-6">
                <label class="block font-medium mb-2">タグ</label>
                <div class="flex flex-wrap gap-4">
                    @foreach ($fixedTags as $id => $label)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="radio"
                            name="tag_id"
                            value="{{ $id }}"
                            {{ old('tag_id', $learning->tag_id) == $id ? 'checked' : '' }}
                            class="accent-blue-600">
                        <span>{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- 表示フラグ --}}
            <div class="mb-6" x-data="{ is_show: {{ old('is_show', $learning->is_show ?? 0) }} }">
                <span class="font-medium mr-4">表示状態</span>

                <div class="inline-flex gap-2">
                    <label
                        class="px-4 py-2 rounded-full cursor-pointer transition"
                        :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'">
                        <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
                        公開
                    </label>

                    <label
                        class="px-4 py-2 rounded-full cursor-pointer transition"
                        :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'">
                        <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
                        非公開
                    </label>
                </div>
            </div>

            {{-- 更新ボタン --}}
            <div class="flex gap-4">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    更新
                </button>

                <a
                    href="{{ route('admin.learnings.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
