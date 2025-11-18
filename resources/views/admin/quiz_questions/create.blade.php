@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">問題追加: {{ $quiz->title }}</h1>

    <form action="{{ route('admin.quizzes.quiz_questions.store', $quiz->id) }}" method="POST">
        @csrf
        <input type="text" name="question_text" placeholder="問題文" required class="border p-2 w-full mb-2">
        <input type="number" name="score" placeholder="点数" value="0" class="border p-2 w-full mb-4">

        <h3>選択肢</h3>
        @for($i=0; $i<4; $i++)
            <div class="mb-2">
            <input type="text" name="choices[{{$i}}][choice_text]" placeholder="選択肢 {{$i+1}}" required class="border p-2">
            <label>
                正解 <input type="checkbox" name="choices[{{$i}}][is_correct]" value="1">
            </label>
</div>
@endfor

<button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">追加</button>
</form>
</div>
@endsection
