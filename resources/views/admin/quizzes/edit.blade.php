@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">

            <h1 class="text-2xl font-bold mb-6 text-gray-800">クイズ編集: {{ $quiz->title }}</h1>

            <div class="mb-6 flex gap-3">
                <a href="{{ route('admin.quizzes.quiz_questions.create', $quiz->id) }}"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">新しい問題を追加</a>
                <a href="{{ route('admin.quizzes.quiz_questions.index', $quiz->id) }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">問題一覧</a>
            </div>

            <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-1">タイトル</label>
                    <input type="text" name="title" value="{{ $quiz->title }}" class="border px-3 py-2 w-full rounded"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">コース選択</label>
                    <select name="course_id" class="border px-3 py-2 w-80 rounded">
                        <option value="">コース選択</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected($quiz->course_id == $course->id)>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block font-medium mb-1">種類</label>
                    <select name="type" class="border px-3 py-2 w-60 rounded" required>
                        <option value="1" @selected($quiz->type == 1)>試験</option>
                        <option value="2" @selected($quiz->type == 2)>アンケート</option>
                        <option value="3" @selected($quiz->type == 3)>練習</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full hover:bg-blue-600">
                    保存
                </button>
            </form>
        </div>
    </div>
@endsection
