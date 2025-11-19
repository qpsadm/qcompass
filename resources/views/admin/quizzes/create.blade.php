@extends('layouts.app')
@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">クイズ作成</h1>

            <form action="{{ route('admin.quizzes.store') }}" method="POST">
                @csrf

                <div class="flex flex-wrap gap-4 mb-4">
                    {{-- タイトル --}}
                    <div class="flex-1 min-w-[200px]">
                        <label class="block font-medium mb-1">タイトル</label>
                        <input type="text" name="title" placeholder="タイトル"
                            class="border border-gray-300 rounded px-3 py-2 w-full focus:ring focus:ring-blue-200">
                    </div>

                    {{-- コース選択 --}}
                    <div class="flex-1 min-w-[150px]">
                        <label class="block font-medium mb-1">コース選択</label>
                        <select name="course_id"
                            class="border border-gray-300 rounded px-3 py-2 w-full focus:ring focus:ring-blue-200">
                            <option value="">選択してください</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 種類 --}}
                    <div class="flex-1 min-w-[150px]">
                        <label class="block font-medium mb-1">種類</label>
                        <select name="type"
                            class="border border-gray-300 rounded px-3 py-2 w-full focus:ring focus:ring-blue-200">
                            <option value="1">試験</option>
                            <option value="2">アンケート</option>
                            <option value="3">練習</option>
                        </select>
                    </div>
                </div>

                {{-- 作成ボタン --}}
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-150">
                    作成
                </button>
            </form>
        </div>
    </div>
@endsection
