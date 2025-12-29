@extends('layouts.f_layout')

@section('main-content')
<div class="container mx-auto p-4 max-w-3xl">
    <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }} - 結果</h1>

    <p class="mb-4">
        合計得点: {{ $totalScore }}<br>
        総問題数: {{ $totalQuestions }}<br>
        合格判定: {{ $passFail }}
    </p>

    @foreach($results as $res)
    <div class="mb-4 p-4 border rounded">
        <p class="font-semibold">{{ $loop->iteration }}. {{ $res['question']->question_text }}</p>
        <p>選択肢:</p>
        <ul class="list-disc pl-5 mb-2">
            @foreach($res['question']->choices as $choice)
            <li>{{ $choice->choice_text }}</li>
            @endforeach
        </ul>
        <p>あなたの回答: {{ is_array($res['userAnswer']) ? implode(', ', $res['userAnswer']) : $res['userAnswer'] }}</p>
        @if($res['isCorrect'] === null)
        <p>記述式のため採点なし</p>
        @elseif($res['isCorrect'])
        <p class="text-green-600 font-bold">正解</p>
        @else
        <p class="text-red-600 font-bold">不正解</p>
        @endif
    </div>
    @endforeach

    <a href="{{ route('user.quizzes.index') }}" class="inline-block mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
        ← クイズ一覧に戻る
    </a>
</div>
@endsection
