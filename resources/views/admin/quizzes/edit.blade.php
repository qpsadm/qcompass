@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-5xl bg-white rounded-lg shadow-md" x-data="{ deleteOpen: false }">

        <h1 class="text-3xl font-bold mb-6">クイズ編集: {{ $quiz->title }}</h1>

        <div class="mb-6 flex gap-3">
            <a href="{{ route('admin.quizzes.quiz_questions.create', $quiz->id) }}"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                クイズ問題を追加
            </a>
            <a href="{{ route('admin.quizzes.quiz_questions.index', $quiz->id) }}"
                class="back bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                クイズ問題一覧
            </a>
        </div>

        {{-- フォーム --}}
        <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full table-auto border-collapse">
                <tbody>

                    {{-- タイトル --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                            タイトル
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="title" value="{{ old('title', $quiz->title) }}"
                                class="border rounded px-3 py-2 w-64" required>
                            @error('title')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- カテゴリ --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">カテゴリ選択</th>
                        <td class="px-4 py-2">
                            <select name="category_id" class="border rounded px-3 py-2 w-64">
                                <option value="">選択してください</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $quiz->category_id) == $category->id)>
                                        {{ $category->name }}
                                        {{ $category->code ? '(' . $category->code . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- レベル --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">レベル</th>
                        <td class="px-4 py-2">
                            <select name="level" class="border rounded px-3 py-2 w-32">
                                <option value="">選択してください</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" @selected(old('level', $quiz->level) == $i)>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('level')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
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
                            @error('type')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 状態 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">状態</th>
                        <td class="px-4 py-2">
                            <select name="status" class="border rounded px-3 py-2 w-32">
                                <option value="1" @selected(old('status', $quiz->status) == 1)>承認待ち</option>
                                <option value="2" @selected(old('status', $quiz->status) == 2)>承認済み</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 表示フラグ --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示フラグ</th>
                        <td class="px-4 py-2" x-data="{ is_show: {{ old('is_show', $quiz->is_show) }} }">
                            <div class="flex gap-2">
                                <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                                    class="px-4 py-2 rounded-full cursor-pointer transition">
                                    <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
                                    公開
                                </label>

                                <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                                    class="px-4 py-2 rounded-full cursor-pointer transition">
                                    <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
                                    非公開
                                </label>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>

            {{-- 操作ボタン --}}
            <div class="mt-6 flex gap-3">
                <button type="submit" class="save bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition">
                    保存する
                </button>

                <a href="{{ route('admin.quizzes.show', $quiz->id) }}"
                    class="back bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition">
                    詳細に戻る
                </a>
            </div>
            <!-- 危険操作ゾーン -->
            <div class="mt-10 pt-6 border-t border-red-200">
                <h2 class="text-red-600 font-semibold mb-2 flex items-center">
                    ⚠ 危険な操作
                </h2>

                <p class="text-sm text-gray-600 mb-4">
                    このクイズを削除すると、元に戻すことはできません。
                </p>

                <button type="button" @click="deleteOpen = true"
                    class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                    削除する
                </button>
            </div>

        </form>

        {{-- 削除確認モーダル --}}
        <div x-show="deleteOpen" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <h2 class="text-lg font-bold mb-4 text-red-600">
                    クイズを削除しますか？
                </h2>

                <p class="text-gray-700 mb-6">
                    この操作は取り消せません。
                </p>

                <div class="flex justify-end gap-3">
                    <button @click="deleteOpen = false" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">
                        キャンセル
                    </button>

                    <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            削除する
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
