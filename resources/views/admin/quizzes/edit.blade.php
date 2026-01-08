@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-5xl bg-white rounded-lg shadow-md">

    <h1 class="text-3xl font-bold mb-6">クイズ編集: {{ $quiz->title }}</h1>

    <div class="mb-6 flex gap-3">
        <a href="{{ route('admin.quizzes.quiz_questions.create', $quiz->id) }}"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
            新しい問題を追加
        </a>
        <a href="{{ route('admin.quizzes.quiz_questions.index', $quiz->id) }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            問題一覧
        </a>
    </div>

    {{-- フォーム --}}
    <form id="update-form" action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
        @csrf
        @method('PUT')

        <table class="w-full table-auto border-collapse">
            <tbody>
                {{-- タイトル --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">タイトル
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                    </th>
                    <td class="px-4 py-2">
                        <input type="text" name="title" value="{{ old('title', $quiz->title) }}"
                            class="border rounded px-3 py-2 w-64" required>
                        @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- カテゴリ --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">カテゴリ選択</th>
                    <td class="px-4 py-2">
                        <select name="category_id" class="border rounded px-3 py-2 w-64" required>
                            <option value="">選択してください</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $quiz->category_id) == $category->id)>
                                {{ $category->name }} {{ $category->code ? '(' . $category->code . ')' : '' }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- レベル --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">レベル</th>
                    <td class="px-4 py-2">
                        <input type="number" name="level" value="{{ old('level', $quiz->level) }}"
                            class="border rounded px-3 py-2 w-32" min="1" max="10">
                        @error('level') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 種類 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">種類</th>
                    <td class="px-4 py-2">
                        <select name="type" class="border rounded px-3 py-2 w-64" required>
                            <option value="1" @selected(old('type', $quiz->type) == 1)>試験</option>
                            <option value="2" @selected(old('type', $quiz->type) == 2)>アンケート</option>
                            <option value="3" @selected(old('type', $quiz->type) == 3)>練習</option>
                        </select>
                        @error('type') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- 保存＋詳細・削除 --}}
        <div x-data="{ showDelete: false }" class="mt-6 flex gap-3">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition">
                保存する
            </button>
            <a href="{{ route('admin.quizzes.show', $quiz->id) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition">
                詳細に戻る
            </a>
            <button type="button" @click="showDelete = true"
                class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded transition">
                削除
            </button>

            {{-- 削除モーダル --}}
            <div x-show="showDelete" x-transition
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-80">
                    <h2 class="text-lg font-bold mb-4">削除確認</h2>
                    <p class="mb-4">本当にこのクイズを削除しますか？</p>
                    <div class="flex justify-end gap-2">
                        <button @click="showDelete = false"
                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                            キャンセル
                        </button>
                        <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">
                                削除する
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

{{-- Alpine.js を読み込む --}}
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
