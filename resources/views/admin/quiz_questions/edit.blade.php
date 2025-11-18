@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">問題編集: {{ $quizQuestion->quiz->title }}</h1>

    <form action="{{ route('admin.quizzes.quiz_questions.update', [$quizQuestion->quiz->id, $quizQuestion->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="question_text" value="{{ $quizQuestion->question_text }}" required class="border p-2 w-full mb-2">
        <input type="number" name="score" value="{{ $quizQuestion->score }}" class="border p-2 w-full mb-4">

        <h3>選択肢</h3>
        @foreach($quizQuestion->choices as $i => $choice)
        <div class="mb-2">
            <input type="text" name="choices[{{$i}}][choice_text]" value="{{ $choice->choice_text }}" required class="border p-2">
            <label>
                正解 <input type="checkbox" name="choices[{{$i}}][is_correct]" value="1" @if($choice->is_correct) checked @endif>
            </label>
        </div>
        @endforeach

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">更新</button>
    </form>
</div>
@endsection
