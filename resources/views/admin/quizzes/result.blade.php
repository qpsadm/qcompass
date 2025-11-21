@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">クイズ結果</h1>

    <div class="mb-4">
        <p>クイズタイトル: <strong>{{ $attempt->quiz->title }}</strong></p>
        <p>合計問題数: <strong>{{ $totalQuestions }}</strong></p>
        <p>正解数: <strong>{{ $totalCorrect }}</strong></p>
    </div>

    <div class="space-y-6">
        @foreach($questions as $index => $question)
        <div class="p-4 border rounded shadow">
            <p class="font-semibold">{{ $index + 1 }}. {{ $question->question_text }}</p>

            <ul class="mt-2 space-y-1">
                @foreach($question->choices as $choice)
                @php
                // ユーザーが選んだ選択肢
                $userAnswer = $attempt->answers->firstWhere('question_id', $question->id);
                $isUserChoice = $userAnswer && $userAnswer->choice_id == $choice->id;

                // 正解かどうか
                $isCorrect = $choice->is_correct;
                @endphp

                <li class="
                            p-2 rounded
                            @if($isUserChoice && $isCorrect) bg-green-200 @endif
                            @if($isUserChoice && !$isCorrect) bg-red-200 @endif
                            @if(!$isUserChoice && $isCorrect) bg-green-100 @endif
                        ">
                    {{ $choice->choice_text }}
                    @if($isUserChoice)
                    <span class="font-bold ml-2">(あなたの回答)</span>
                    @endif
                    @if($isCorrect)
                    <span class="text-green-600 font-bold ml-2">正解</span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</div>
@endsection
