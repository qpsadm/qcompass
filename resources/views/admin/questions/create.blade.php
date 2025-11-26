@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-5xl bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6">質問作成</h1>

        <form action="{{ route('admin.questions.store') }}" method="POST" x-data="questionForm()" x-init="init()">
            @csrf
            <table class="w-full table-auto border-collapse">
                <tbody>
                    {{-- 講座 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座

                        </th>
                        <td class="px-4 py-2">
                            <select name="course_id" x-model="selectedCourse" @change="filterTeachers()"
                                class="border rounded px-3 py-2 w-80">
                                <option value="">選択してください</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('course_id') == $course->id ? 'selected' : '' }}>
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
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">質問タイトル
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="border rounded px-3 py-2 w-96">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 回答講師 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">回答講師

                        </th>
                        <td class="px-4 py-2">
                            <select name="responder_id" class="border rounded px-3 py-2 w-80">
                                <option value="">選択してください</option>
                                <template x-for="teacher in teachers" :key="teacher.id">
                                    <option :value="teacher.id" x-text="teacher.name"></option>
                                </template>
                            </select>
                            @error('responder_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 質問内容 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">質問内容
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <textarea name="content" rows="4" class="border rounded px-3 py-2 w-full">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 回答内容 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">回答内容
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <textarea name="answer" rows="4" class="border rounded px-3 py-2 w-full">{{ old('answer') }}</textarea>
                            @error('answer')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- タグ --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">タグ <span
                                class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span></th>

                        <td class="px-4 py-2">
                            <div class="flex flex-wrap gap-3">
                                @foreach ($tags as $tag)
                                    <label class="flex items-center space-x-1">
                                        <input type="radio" name="tags_id" value="{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                        <span>{{ $tag->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </td>
                    </tr>

                    {{-- 公開 / 非公開 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">公開 / 非公開</th>
                        <td class="px-4 py-2">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="is_show" value="1"
                                    {{ old('is_show', 1) ? 'checked' : '' }}>
                                <span>公開</span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- ボタン --}}
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition">
                    保存する
                </button>
                <a href="{{ route('admin.questions.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>

    <script>
        function questionForm() {
            return {
                selectedCourse: @json(old('course_id')),
                coursesTeachers: @json($coursesTeachers),
                teachers: [],
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
