@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">

        {{-- 白いカード枠 --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">質問作成</h1>

            <form action="{{ route('admin.questions.store') }}" method="POST">
                @csrf

                {{-- 講座選択 --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">講座</label>
                    <select name="course_id" class="border px-2 py-1 w-full">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 担当講師選択（講座ごとに表示） --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">担当講師</label>
                    <select name="responder_id" class="border px-2 py-1 w-full">
                        <option value="">選択してください</option>
                        @foreach ($courses as $course)
                            <optgroup label="{{ $course->course_name }}">
                                @foreach ($coursesTeachers[$course->id] as $teacher)
                                    <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('responder_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 質問タイトル --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">質問タイトル</label>
                    <input type="text" name="title" class="border px-2 py-1 w-full" value="{{ old('title') }}">
                    @error('title')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 質問内容 --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">質問内容</label>
                    <textarea name="content" class="border px-2 py-1 w-full">{{ old('content') }}</textarea>
                </div>

                {{-- 回答 --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">回答</label>
                    <textarea name="answer" class="border px-2 py-1 w-full">{{ old('answer') }}</textarea>
                </div>

                {{-- タグ --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">タグ</label>
                    <select name="tag_id" class="border px-2 py-1 w-full">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    @error('tag_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 公開設定 --}}
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_show" class="mr-2" value="1">
                        公開する
                    </label>
                </div>

                {{-- ボタン --}}
                <div class="flex items-center space-x-3 mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">作成</button>
                    <a href="{{ route('admin.questions.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>

    </div>
@endsection
