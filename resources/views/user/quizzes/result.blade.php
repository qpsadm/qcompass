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
        {{-- 問題文 --}}
        <p class="font-semibold mb-2">
            {{ $loop->iteration }}. {{ $res['question']->question_text }}
        </p>

        {{-- 選択肢一覧 --}}
        <p class="font-medium">選択肢:</p>
        <ul class="list-disc pl-5 mb-2">
            @foreach($res['question']->choices as $choice)
            <li>{{ $choice->choice_text }}</li>
            @endforeach
        </ul>

        {{-- あなたの回答（★ここが今回の修正ポイント） --}}
        <p>
            あなたの回答:
            @php
            // [choice_id => choice_text] の対応表を作る
            $choiceMap = $res['question']->choices->pluck('choice_text', 'id');
            @endphp

            @if (is_array($res['userAnswer']))
            {{ collect($res['userAnswer'])
                    ->map(fn($id) => $choiceMap[$id] ?? '不明')
                    ->implode(', ') }}
            @else
            {{ $choiceMap[$res['userAnswer']] ?? $res['userAnswer'] }}
            @endif
        </p>

        {{-- 正解・不正解表示 --}}
        @if($res['isCorrect'] === null)
        <p class="text-gray-500">記述式のため採点なし</p>
        @elseif($res['isCorrect'])
        <p class="text-green-600 font-bold">正解</p>
        @else
        <p class="text-red-600 font-bold">不正解</p>
        @endif
    </div>
    @endforeach

    <a href="{{ route('user.quizzes.index') }}"
        class="inline-block mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
        ← クイズ一覧に戻る
    </a>
</div>
@endsection
