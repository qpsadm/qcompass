@extends('layouts.f_layout')

@section('main-content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }} - 結果</h1>

    <p class="mb-4">合計得点: {{ $score }} / {{ $totalScore }}</p>

    @foreach($results as $res)
    <div class="mb-4 p-4 border rounded">
        <p class="font-semibold">{{ $loop->iteration }}. {{ $res['question']->question_text }}</p>
        <p>あなたの回答: {{ $res['userAnswer'] }}</p>
        @if($res['isCorrect'] === null)
        <p>記述式のため採点なし</p>
        @elseif($res['isCorrect'])
        <p class="text-green-600">正解</p>
        @else
        <p class="text-red-600">不正解</p>
        @endif
    </div>
    @endforeach

    <a href="{{ route('user.quizzes.index') }}" class="mt-2 inline-block bg-gray-500 text-white px-4 py-2 rounded">
        クイズ一覧へ戻る
    </a>
</div>
@endsection
