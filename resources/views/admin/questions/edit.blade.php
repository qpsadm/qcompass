@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold mb-6">質問編集</h1>

            <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" x-data="questionForm()"
                x-init="init()">
                @csrf
                @method('PUT')

                <table class="w-full table-auto border-collapse">
                    <tbody>
                        {{-- 講座 --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                                講座
                            </th>
                            <td class="px-4 py-2">
                                <select name="course_id" x-model="selectedCourse" @change="filterTeachers()"
                                    class="border rounded px-3 py-2 w-full" required>
                                    <option value="">選択してください</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id', $question->course_id) == $course->id ? 'selected' : '' }}>
                                            {{ $course->course_name }} ({{ $course->course_code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 質問タイトル --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                質問タイトル
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="text" name="title" value="{{ old('title', $question->title) }}"
                                    class="border rounded px-3 py-2 w-full" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 回答講師 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                回答講師
                            </th>
                            <td class="px-4 py-2">
                                <select name="responder_id" class="border rounded px-3 py-2 w-full" required>
                                    <option value="">選択してください</option>
                                    <template x-for="teacher in teachers" :key="teacher.id">
                                        <option :value="teacher.id" x-text="teacher.name"
                                            :selected="teacher.id == {{ old('responder_id', $question->responder_id) }}">
                                        </option>
                                    </template>
                                </select>
                                @error('responder_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 質問内容 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                質問内容
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <textarea name="content" rows="4" class="border rounded px-3 py-2 w-full" required>{{ old('content', $question->content) }}</textarea>
                                @error('content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 回答内容 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                回答内容
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <textarea name="answer" rows="4" class="border rounded px-3 py-2 w-full" required>{{ old('answer', $question->answer) }}</textarea>
                                @error('answer')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- タグ（ラジオボタン） --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                タグ
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-3">
                                    <template x-for="tag in tags" :key="tag.id">
                                        <label
                                            class="flex items-center space-x-1 bg-gray-100 px-2 py-1 rounded border hover:bg-gray-200 cursor-pointer">
                                            <input type="radio" name="tag_id" :value="tag.id"
                                                :checked="tag.id == selectedTag" required>
                                            <span x-text="tag.name"></span>
                                        </label>
                                    </template>
                                </div>
                                @error('tag_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 公開 / 非公開 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">公開 / 非公開</th>
                            <td class="px-4 py-2">
                                <select name="is_show" class="border rounded px-3 py-2 w-full">
                                    <option value="1" {{ old('is_show', $question->is_show) == 1 ? 'selected' : '' }}>
                                        公開</option>
                                    <option value="0" {{ old('is_show', $question->is_show) == 0 ? 'selected' : '' }}>
                                        非公開</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">保存する</button>
                    <a href="{{ route('admin.questions.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
                </div>
            </form>

        </div>
    </div>

    <script>
        function questionForm() {
            return {
                selectedCourse: @json(old('course_id', $question->course_id)),
                coursesTeachers: @json($coursesTeachers),
                teachers: [],
                tags: @json($tags), // タグデータを渡す
                selectedTag: @json(old('tag_id', $question->tag_id)), // タグ選択状態
                init() {
                    this.filterTeachers();
                },
                filterTeachers() {
                    const key = String(this.selectedCourse).trim();
                    this.teachers = this.coursesTeachers[key] || [];
                }
            }
        }
    </script>
@endsection
