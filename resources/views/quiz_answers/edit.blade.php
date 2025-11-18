@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">解答編集</h1>
        <form action="{{ route('quiz_answers.update', $QuizAnswer->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">紐づく受験履歴ID</label>
                <input type="text" name="attempt_id" value="{{ old('attempt_id', $QuizAnswer->attempt_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">設問ID</label>
                <input type="text" name="question_id" value="{{ old('question_id', $QuizAnswer->question_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">選択肢ID</label>
                <input type="text" name="choice_id" value="{{ old('choice_id', $QuizAnswer->choice_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">自由解答時の内容</label>
                <input type="text" name="answer_text" value="{{ old('answer_text', $QuizAnswer->answer_text ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">正誤判定</label>
                <input type="text" name="is_correct" value="{{ old('is_correct', $QuizAnswer->is_correct ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">採点後のスコア</label>
                <input type="text" name="score" value="{{ old('score', $QuizAnswer->score ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
@endsection
