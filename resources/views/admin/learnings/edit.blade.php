@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6" x-data="{ deleteOpen: false }">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">学習コンテンツ編集：{{ $learning->title ?? '新規作成' }}</h1>

        @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.learnings.update', $learning->id) }}" method="POST" enctype="multipart/form-data"
            x-data="{ type: '{{ old('type', $learning->type) }}', is_show: {{ old('is_show', $learning->is_show ?? 1) }} }">
            @csrf
            @method('PUT')

            @php
            $types = [
            'book' => '参考書籍',
            'site' => '参考サイト',
            'video' => 'IT資格',
            'article' => '製作品',
            'other' => 'その他',
            ];
            $levels = [1 => '初級', 2 => '上級'];
            $tags = [
            1 => 'WEB制作',
            2 => 'WEBデザイン',
            3 => 'プログラミング',
            4 => 'OA',
            5 => 'その他',
            ];
            @endphp

            {{-- 種別 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">種類 <span class="text-red-500">*</span></label>
                <select name="type" class="border px-3 py-2 w-full rounded" required x-model="type">
                    <option value="">選択してください</option>
                    @foreach ($types as $value => $label)
                    <option value="{{ $value }}" {{ old('type', $learning->type) == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- タイトル --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">タイトル <span class="text-red-500">*</span></label>
                <input type="text" name="title" class="border px-3 py-2 w-full rounded" value="{{ old('title', $learning->title) }}" required>
            </div>

            {{-- 説明 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">説明</label>
                <textarea name="description" class="border px-3 py-2 w-full rounded" rows="3">{{ old('description', $learning->description) }}</textarea>
            </div>

            {{-- 画像 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">画像（URL またはファイル）</label>
                <input type="text" name="image" placeholder="画像URL" class="border px-3 py-2 w-full rounded" value="{{ old('image', $learning->image) }}">
                <input type="file" name="image_file" class="mt-2 w-full">
            </div>

            {{-- URL --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">参照URL</label>
                <input type="text" name="url" class="border px-3 py-2 w-full rounded" value="{{ old('url', $learning->url) }}">
            </div>

            {{-- レベル --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">レベル <span class="text-red-500">*</span></label>
                <select name="level" class="border px-3 py-2 w-full rounded" required>
                    <option value="">選択してください</option>
                    @foreach ($levels as $id => $label)
                    <option value="{{ $id }}" {{ old('level', $learning->level) == $id ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- タグ --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">タグ <span class="text-red-500">*</span></label>
                <div class="flex flex-wrap gap-4">
                    @foreach ($tags as $id => $label)
                    <label class="inline-flex items-center gap-1">
                        <input type="radio" name="tag_id" value="{{ $id }}" {{ old('tag_id', $learning->tag_id) == $id ? 'checked' : '' }}>
                        {{ $label }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- 訓練科名（製作品のみ表示） --}}
            <div class="mb-4" x-show="type === 'article'">
                <label class="block font-medium mb-1">訓練科名</label>
                <input type="text" name="course_name" class="border px-3 py-2 w-full rounded" value="{{ old('course_name', $learning->course_name) }}">
            </div>

            {{-- 制作期間（製作品のみ表示） --}}
            <div class="mb-4" x-show="type === 'article'">
                <label class="block font-medium mb-1">制作期間</label>
                <input type="text" name="priod" class="border px-3 py-2 w-full rounded" value="{{ old('priod', $learning->priod) }}">
            </div>

            {{-- 表示 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">表示状態</label>
                <div class="inline-flex gap-2">
                    <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-4 py-2 rounded cursor-pointer">
                        <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show"> 公開
                    </label>
                    <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'" class="px-4 py-2 rounded cursor-pointer">
                        <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show"> 非公開
                    </label>
                </div>
            </div>

            {{-- ボタン --}}
            <div class="flex gap-4 mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">更新</button>
                <a href="{{ route('admin.learnings.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
            </div>
        </form>

        {{-- 危険操作ゾーン --}}
        <div class="mt-10 pt-6 border-t border-red-200" x-show="{{ isset($learning) ? 'true' : 'false' }}">
            <h2 class="text-red-600 font-semibold mb-2">⚠ 危険な操作</h2>
            <p class="text-sm text-gray-600 mb-4">
                この学習コンテンツを削除すると、元に戻すことはできません。
            </p>
            <button @click="deleteOpen = true" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                削除する
            </button>
        </div>

        {{-- 削除確認モーダル --}}
        <div x-show="deleteOpen" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div x-show="deleteOpen" x-transition.scale.duration.200ms class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                <p class="text-gray-700 text-center mb-5">
                    「{{ $learning->title ?? 'この学習コンテンツ' }}」を削除しますか？
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <button @click="deleteOpen = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        キャンセル
                    </button>
                    <form action="{{ route('admin.learnings.destroy', $learning->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            削除する
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
@endsection
