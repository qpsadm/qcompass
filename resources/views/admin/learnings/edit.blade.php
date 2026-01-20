@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 flex justify-center">

    <div class="bg-white rounded-lg shadow-md w-full max-w-2xl p-6">
        <h1 class="text-2xl font-bold mb-4">学習コンテンツ編集：{{ $learning->title ?? '新規作成' }}</h1>

        {{-- バリデーションエラー --}}
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Alpine.js で初期値管理 --}}
        <form action="{{ route('admin.learnings.update', $learning->id) }}" method="POST" enctype="multipart/form-data"
            x-data="{
                  type: {{ json_encode(old('type', $learning->type)) }},
                  is_show: {{ old('is_show', $learning->is_show ?? 1) }},
                  description: {{ json_encode(old('description', $learning->description ?? '')) }}
              }">
            @csrf
            @method('PUT')

            @php
            $types = ['book'=>'参考書籍','site'=>'参考サイト','video'=>'IT資格','article'=>'制作品'];
            $levels = [1=>'初級',2=>'上級'];
            $tags = [1=>'WEB制作',2=>'WEBデザイン',3=>'プログラミング',4=>'OA',5=>'その他'];
            @endphp

            {{-- 種類 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">種類 <span class="text-red-500">*</span></label>
                <select name="type" class="border px-3 py-2 w-full rounded" required x-model="type">
                    <option value="">選択してください</option>
                    @foreach ($types as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- タイトル --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">タイトル <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $learning->title) }}"
                    class="border px-3 py-2 w-full rounded" required>
            </div>

            {{-- 説明 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">説明</label>
                <textarea name="description" x-model="description"
                    class="border px-3 py-2 w-full rounded" rows="5"></textarea>
            </div>

            {{-- 画像 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">画像（URL またはファイル）</label>
                <input type="text" name="image" value="{{ old('image', $learning->image) }}" class="border px-3 py-2 w-full rounded">
                <input type="file" name="image_file" class="mt-2 w-full">
                <label class="inline-flex items-center mt-2">
                    <input type="checkbox" name="delete_image" value="1"> 既存画像を削除
                </label>
            </div>

            {{-- 参照URL --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">参照URL</label>
                <input type="text" name="url" value="{{ old('url', $learning->url) }}"
                    class="border px-3 py-2 w-full rounded">
            </div>

            {{-- レベル --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">レベル <span class="text-red-500">*</span></label>
                <select name="level" class="border px-3 py-2 w-full rounded" required>
                    <option value="">選択してください</option>
                    @foreach ($levels as $id => $label)
                    <option value="{{ $id }}" {{ old('level', $learning->level) == $id ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- タグ --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">タグ <span class="text-red-500">*</span></label>
                <div class="flex flex-wrap gap-4">
                    @foreach ($tags as $id => $label)
                    <label class="inline-flex items-center gap-1">
                        <input type="radio" name="tag_id" value="{{ $id }}"
                            {{ old('tag_id', $learning->tag_id) == $id ? 'checked' : '' }}>
                        {{ $label }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- 制作品専用 --}}
            <div class="mb-4" x-show="type === 'article'">
                <label class="block font-medium mb-1">訓練科名</label>
                <input type="text" name="course_name" value="{{ old('course_name', $learning->course_name) }}"
                    class="border px-3 py-2 w-full rounded">
            </div>
            <div class="mb-4" x-show="type === 'article'">
                <label class="block font-medium mb-1">制作期間</label>
                <input type="text" name="priod" value="{{ old('priod', $learning->priod) }}"
                    class="border px-3 py-2 w-full rounded">
            </div>

            {{-- 表示状態 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">表示状態</label>
                <div class="inline-flex gap-2">
                    <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded cursor-pointer">
                        <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show"> 公開
                    </label>
                    <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded cursor-pointer">
                        <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show"> 非公開
                    </label>
                </div>
            </div>

            <div class="flex gap-2 mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">更新</button>
                <a href="{{ route('admin.learnings.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">一覧に戻る</a>
            </div>
        </form>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
@endsection
