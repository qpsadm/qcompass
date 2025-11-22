@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 min-h-screen">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 max-w-3xl mx-auto"
        x-data="{
             selectedCourse: '{{ old('course_id', '') }}',
             teachers: [],
             init() {
                 this.filterTeachers();
             },
             filterTeachers() {
                 if (this.selectedCourse) {
                     this.teachers = @json($coursesTeachers)[this.selectedCourse] || [];
                 } else {
                     this.teachers = [];
                 }
             }
         }"
        x-init="init()">

        <h1 class="text-2xl font-bold mb-6">質問作成</h1>

        <form action="{{ route('admin.questions.store') }}" method="POST">
            @csrf

            {{-- 講座選択 --}}
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">講座</label>
                <select name="course_id"
                    x-model="selectedCourse"
                    @change="filterTeachers()"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <option value="">選択してください</option>
                    @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->course_name }} ({{ $course->course_code }})
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- 質問タイトル --}}
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">質問タイトル</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>

            {{-- 回答講師選択 --}}
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">回答講師</label>
                <select name="responder_id"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <option value="">選択してください</option>
                    <template x-for="teacher in teachers" :key="teacher.id">
                        <option :value="teacher.id" x-text="teacher.name"></option>
                    </template>
                </select>
            </div>

            {{-- 質問内容 --}}
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">質問内容</label>
                <textarea name="content" rows="3"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">{{ old('content') }}</textarea>
            </div>

            {{-- 回答内容 --}}
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">回答内容</label>
                <textarea name="answer" rows="3"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">{{ old('answer') }}</textarea>
            </div>

            {{-- 公開 / 非公開 --}}
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">公開 / 非公開</label>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_show" value="1" {{ old('is_show', 1) ? 'checked' : '' }}>
                        <span class="text-gray-700">公開</span>
                    </label>
                </div>
            </div>

            {{-- 保存＋一覧に戻る --}}
            <div class="flex gap-2 mt-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                    保存
                </button>

                <a href="{{ route('admin.questions.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
