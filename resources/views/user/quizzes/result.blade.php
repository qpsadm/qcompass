@extends('layouts.f_layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }} - 結果</h1>

    <p class="mb-4">合計得点: {{ $score }} / {{ $quiz->total_score }}</p>
    <p class="mb-4">
        合格: {{ $quiz->passing_score }} 点以上
        @if($score >= $quiz->passing_score)
        <span class="text-green-600 font-semibold">合格！</span>
        @else
        <span class="text-red-600 font-semibold">不合格</span>
        @endif
    </p>

    @foreach($results as $res)
    <div class="mb-4 p-4 border rounded">
        <p class="font-semibold">{{ $loop->iteration }}. {{ $res['question']->question_text }}</p>
        <p>あなたの回答:
            @if(is_array($res['userAnswer']))
            {{ implode(', ', $res['userAnswer']) }}
            @else
            {{ $res['userAnswer'] }}
            @endif
        </p>
        @if($res['isCorrect'] === null)
        <p>記述式のため採点なし</p>
        @elseif($res['isCorrect'])
        <p class="text-green-600">正解</p>
        @else
        <p class="text-red-600">不正解</p>
        @endif
    </div>
    @endforeach
</div>
@endsection
