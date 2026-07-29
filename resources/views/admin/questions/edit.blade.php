@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <div class="bg-white rounded-lg shadow-md p-6" x-data="{ deleteOpen: false }">

            <h1 class="text-3xl font-bold mb-6">質疑応答編集</h1>

            {{-- ================= 編集フォーム ================= --}}
            <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" x-data="questionForm()"
                x-init="init()">

                @csrf
                @method('PUT')

                <table class="w-full table-auto border-collapse">
                    <tbody>

                        {{-- 講座 --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座</th>
                            <td class="px-4 py-2">
                                <select name="course_id" x-model="selectedCourse" @change="filterTeachers()"
                                    class="border rounded px-3 py-2 w-full">
                                    <option value="">選択してください</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">
                                            {{ $course->course_name }} ({{ $course->course_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        {{-- 質問タイトル --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                質問タイトル
                                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="text" name="title" value="{{ old('title', $question->title) }}"
                                    class="border rounded px-3 py-2 w-full" required>
                            </td>
                        </tr>

                        {{-- 回答講師 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">回答講師</th>
                            <td class="px-4 py-2">
                                <select name="responder_id" x-model="selectedResponder"
                                    class="border rounded px-3 py-2 w-full">
                                    <option value="">選択してください</option>
                                    <template x-for="teacher in teachers" :key="teacher.id">
                                        <option :value="teacher.id" x-text="teacher.name"></option>
                                    </template>
                                </select>
                            </td>
                        </tr>

                        {{-- 質問内容 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                質問内容
                                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <textarea name="content" rows="4" class="border rounded px-3 py-2 w-full" required>{{ old('content', $question->content) }}</textarea>
                            </td>
                        </tr>

                        {{-- 回答内容 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                回答内容
                                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <textarea name="answer" rows="4" class="border rounded px-3 py-2 w-full" required>{{ old('answer', $question->answer) }}</textarea>
                            </td>
                        </tr>

                        {{-- タグ --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                タグ
                                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-3">
                                    <template x-for="tag in tags" :key="tag.id">
                                        <label class="flex items-center gap-1 bg-gray-100 px-2 py-1 rounded cursor-pointer">
                                            <input type="radio" name="tag_id" :value="tag.id"
                                                x-model="selectedTag" required>
                                            <span x-text="tag.name"></span>
                                        </label>
                                    </template>
                                </div>
                            </td>
                        </tr>

                        {{-- 表示フラグ --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">表示フラグ</th>
                            <td class="px-4 py-2" x-data="{ is_show: {{ old('is_show', $question->is_show) }} }">
                                <div class="flex gap-2">
                                    <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200'"
                                        class="px-4 py-2 rounded-full cursor-pointer">
                                        <input type="radio" name="is_show" value="1" class="hidden"
                                            x-model="is_show">
                                        公開
                                    </label>
                                    <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200'"
                                        class="px-4 py-2 rounded-full cursor-pointer">
                                        <input type="radio" name="is_show" value="0" class="hidden"
                                            x-model="is_show">
                                        非公開
                                    </label>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

                {{-- 保存ボタン --}}
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="save bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                        保存する
                    </button>
                    <a href="{{ route('admin.questions.index') }}"
                        class="back bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>

            {{-- ================= 危険領域 ================= --}}
            <div class="mt-10 border-t pt-6">
                <h2 class="text-lg font-bold text-red-600 mb-2">危険な操作</h2>
                <p class="text-sm text-gray-600 mb-4">
                    この質疑応答を削除すると元に戻せません。
                </p>

                <button @click="deleteOpen = true" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded">
                    削除する
                </button>
            </div>

            {{-- ================= 削除モーダル ================= --}}
            <div x-show="deleteOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                x-cloak>
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                    <h3 class="text-xl font-bold text-red-600 mb-4">削除確認</h3>
                    <p class="mb-6">本当にこの質疑応答を削除しますか？</p>

                    <div class="flex justify-end gap-3">
                        <button @click="deleteOpen = false" class="bg-gray-300 px-4 py-2 rounded">
                            キャンセル
                        </button>

                        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                削除する
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= Alpine.js ================= --}}
    <script>
        function questionForm() {
            return {
                selectedCourse: @json(old('course_id', $question->course_id)),
                selectedResponder: @json(old('responder_id', $question->responder_id)),
                coursesTeachers: @json($coursesTeachers),
                teachers: [],
                tags: @json($tags),
                selectedTag: @json(old('tag_id', $question->tag_id)),
                init() {
                    this.filterTeachers();
                },
                filterTeachers() {
                    const key = String(this.selectedCourse ?? '').trim();
                    this.teachers = this.coursesTeachers[key] || [];
                }
            }
        }
    </script>
@endsection
