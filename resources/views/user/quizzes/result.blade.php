@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-start justify-center bg-gray-100 pt-10">
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200 w-full max-w-xl">
            <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }} - 結果</h1>
            <p class="mb-4 font-bold">合計得点: {{ $score }}</p>

            @foreach ($results as $res)
                <div class="mb-4 p-4 border rounded">
                    <p class="font-bold">{{ $res['question']->question_text }} ({{ $res['question']->score }}点)</p>

                    @if ($res['question']->question_type === 'text')
                        <p>あなたの回答: {{ $res['userAnswer'] }}</p>
                    @else
                        <p>あなたの回答:
                            @foreach ((array) $res['userAnswer'] as $ans)
                                {{ $res['question']->choices->firstWhere('id', $ans)?->choice_text }},
                            @endforeach
                        </p>
                        <p>正解:
                            @foreach ($res['question']->choices->where('is_correct', 1) as $c)
                                {{ $c->choice_text }},
                            @endforeach
                        </p>
                        <p>判定: <span class="{{ $res['isCorrect'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $res['isCorrect'] ? '正解' : '不正解' }}
                            </span></p>
                    @endif
                </div>
            @endforeach
        </div>
    @endsection
