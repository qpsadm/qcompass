@extends('layouts.f_layout')

@section('title', 'クイズ結果')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_quiz.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <x-f_page_title :search="false" title="クイズ [{{ $quiz->title }}] 結果" />

        <div class="result">
            <div>
                <div class="point">
                    <p>合計得点</p>
                    <span>{{ $totalScore }}</span>
                    <p>点</p>
                </div>
                <div class="count">
                    <p>全{{ $totalQuestions }}問中</p>
                    <span>{{ $passingScore }}</span>
                    <p>問正解！</p>
                </div>
            </div>
            <p class="hantei {{ $passFail == '合格' ? 'active' : '' }}">{{ $passFail }}</p>
        </div>

        <table class="result-table">
            <tr>
                <th class="table-number">No</th>
                <th class="table-question">問題文</th>
                <th class="table-select">選択肢</th>
                <th class="table-seikai">あなたの回答</th>
                <th class="table-hantei">判定</th>
            </tr>
            @foreach ($results as $res)
                <tr>
                    <td class="table-number">{{ $loop->iteration }}</td>
                    <td class="table-question">{{ $res['question']->question_text }}</td>
                    <td class="table-select">
                        <ul>
                            @foreach ($res['question']->choices as $choice)
                                <li>{{ $choice->choice_text }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="table-seikai">
                        @php
                            // [choice_id => choice_text] の対応表を作る
                            $choiceMap = $res['question']->choices->pluck('choice_text', 'id');
                        @endphp

                        @if (is_array($res['userAnswer']))
                            {{ collect($res['userAnswer'])->map(fn($id) => $choiceMap[$id] ?? '不明')->implode(', ') }}
                        @else
                            {{ $choiceMap[$res['userAnswer']] ?? $res['userAnswer'] }}
                        @endif
                    </td>
                    <td class="table-hantei">
                        @if ($res['isCorrect'] === null)
                            <p class="text-gray-500">記述式のため採点なし</p>
                        @elseif($res['isCorrect'])
                            <p class="text-green-600 font-bold">正解</p>
                        @else
                            <p class="text-red-600 font-bold">不正解</p>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        <a href="{{ route('user.quizzes.index') }}" class="back-btn result-back">
            一覧へもどる
        </a>

        <x-f_bread_crumbs />
    </div>
@endsection
