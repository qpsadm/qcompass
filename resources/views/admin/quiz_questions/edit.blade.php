@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">問題編集: {{ $quizQuestion->quiz->title }}</h1>

            <form action="{{ route('admin.quizzes.quiz_questions.update', [$quizQuestion->quiz->id, $quizQuestion->id]) }}"
                method="POST">
                @csrf
                @method('PUT')

                {{-- 問題文 --}}
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700 mb-1">問題文</label>
                    <input type="text" name="question_text" value="{{ $quizQuestion->question_text }}" required
                        class="border border-gray-300 rounded px-3 py-2 w-full focus:ring focus:ring-blue-200">
                </div>

                {{-- 配点 --}}
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700 mb-1">配点</label>
                    <input type="number" name="score" value="{{ $quizQuestion->score }}"
                        class="border border-gray-300 rounded px-3 py-2 w-32 focus:ring focus:ring-blue-200">
                </div>

                {{-- 選択肢 --}}
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700 mb-2">選択肢</label>
                    <div class="space-y-2">
                        @foreach ($quizQuestion->choices as $i => $choice)
                            <div class="flex items-center gap-2">
                                <input type="text" name="choices[{{ $i }}][choice_text]"
                                    value="{{ $choice->choice_text }}" required
                                    class="border border-gray-300 rounded px-3 py-2 flex-1 focus:ring focus:ring-blue-200">
                                <label class="flex items-center gap-1">
                                    <input type="checkbox" name="choices[{{ $i }}][is_correct]" value="1"
                                        @if ($choice->is_correct) checked @endif>
                                    正解
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 送信ボタン --}}
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
                    更新
                </button>
            </form>
        </div>
    </div>
@endsection
