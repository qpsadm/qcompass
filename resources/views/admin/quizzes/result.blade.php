@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $attempt->quiz->title }} - 結果</h1>

    <p>正解数: {{ $totalCorrect }} / {{ $totalQuestions }}</p>

    <hr class="my-4">

    @foreach($questions as $question)
    <div class="mb-4 p-4 border rounded">
        <p class="font-semibold">{{ $loop->iteration }}. {{ $question->text }}</p>

        <ul class="ml-4">
            @foreach($question->choices as $choice)
            @php
            $userAnswer = $attempt->answers->firstWhere('question_id', $question->id);
            $isCorrectChoice = $choice->is_correct;
            $isUserChoice = $userAnswer && $userAnswer->choice_id == $choice->id;
            @endphp

            <li class="
                        @if($isCorrectChoice) text-green-600 font-bold @endif
                        @if($isUserChoice && !$isCorrectChoice) text-red-600 @endif
                    ">
                {{ $choice->text }}
                @if($isUserChoice) (あなたの回答) @endif
                @if($isCorrectChoice) (正解) @endif
            </li>
            @endforeach
        </ul>
    </div>
    @endforeach
</div>
@endsection
