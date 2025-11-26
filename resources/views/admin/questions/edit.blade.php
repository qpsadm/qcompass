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
                            <td class="px-4
