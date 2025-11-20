@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">

            <h1 class="text-2xl font-bold mb-6">質問作成</h1>

            <form action="{{ route('admin.questions.store') }}" method="POST">
                @csrf

                {{-- 講座選択 --}}
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">講座</label>
                    <select name="course_id"
                        class="w-[400px] border border-gray-300 rounded-md px-3 py-2
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           outline-none focus:outline-none">
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
                        class="w-full border border-gray-300 rounded-md px-3 py-2
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           outline-none focus:outline-none">
                </div>

                {{-- 回答講師ID --}}
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">回答講師ID</label>
                    <input type="text" name="responder_id" value="{{ old('responder_id') }}"
                        class="w-[150px] border border-gray-300 rounded-md px-3 py-2
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           outline-none focus:outline-none">
                </div>

                {{-- 質問内容 --}}
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">質問内容</label>
                    <textarea name="content" rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           outline-none focus:outline-none">{{ old('content') }}</textarea>
                </div>

                {{-- 回答内容 --}}
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">回答内容</label>
                    <textarea name="answer" rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           outline-none focus:outline-none">{{ old('answer') }}</textarea>
                </div>

                {{-- 公開/非公開 --}}
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">公開 / 非公開</label>
                    <select name="is_show"
                        class="w-[200px] border border-gray-300 rounded-md px-3 py-2
               focus:ring-2 focus:ring-blue-500 focus:border-blue-500
               outline-none focus:outline-none">
                        <option value="">選択してください</option>
                        <option value="1" {{ old('is_show') == '1' ? 'selected' : '' }}>公開</option>
                        <option value="0" {{ old('is_show') == '0' ? 'selected' : '' }}>非公開</option>
                    </select>
                </div>

                {{-- 削除日 --}}
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">削除日</label>
                    <input type="date" name="deleted_at" value="{{ old('deleted_at') }}"
                        class="w-[200px] border border-gray-300 rounded-md px-3 py-2
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           outline-none focus:outline-none">
                </div>

                <div class="flex gap-2 mt-2">
                    <!-- 保存ボタン -->
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                        保存
                    </button>

                    <!-- 一覧に戻るボタン -->
                    <a href="{{ route('admin.course_type.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
