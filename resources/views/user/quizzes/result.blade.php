@extends('layouts.f_layout')

@section('title', 'クイズ結果')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_quiz.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームなし） -->
        <x-f_page_title :search="false" title="クイズ [{{ $quiz->title }}] 結果" />

        <!-- 結果判定 -->
        <div class="result">
            <div class="result-left">
                <div class="point">
                    <p>合計得点</p>
                    <span>{{ $totalScore }}</span>
                    <p>点</p>
                </div>
                <div class="count">
                    <p>全{{ $totalQuestions }}問中</p>
                    <span>{{ $correctCount }}</span>
                    <p>問正解！</p>
                </div>
            </div>
            <div class="result-right">
                <p class="decision {{ $passFail === '合格' ? 'active' : '' }}">
                    {{ $passFail }}
                </p>
            </div>
        </div>

        <!-- コンテンツ詳細（文字サイズ変更対象） -->
        <div class="result-container
            @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">
            <table class="result-table">
                <tr>
                    <th class="table-number">No</th>
                    <th class="table-question">問題文</th>
                    <th class="table-select">選択肢<br>（正答は赤字）</th>
                    <th class="table-answer">あなたの回答</th>
                    <th class="table-decision">判定</th>
                </tr>

                @foreach ($results as $res)
                    <tr>
                        <td class="table-number">{{ $loop->iteration }}</td>

                        <!-- 問題文 -->
                        <td class="table-question">
                            {!! nl2br($res['question']->question_text) !!}
                        </td>

                        <!-- 選択肢（正答は赤字で表示） -->
                        <td class="table-select">
                            <ul>
                                @foreach ($res['question']->choices as $choice)
                                    <li class="{{ $choice->is_correct ? 'choice-correct' : '' }}">
                                        {{ $choice->choice_text }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        <!-- ユーザー回答 -->
                        <td class="table-answer">
                            @php
                                $choiceMap = $res['question']->choices->pluck('choice_text', 'id');
                                $userAnswer = $res['userAnswer'] ?? null;
                            @endphp

                            @if (is_array($userAnswer))
                                {!! collect($userAnswer)->map(fn($id) => '<span class="choice-user">' . ($choiceMap[$id] ?? '不明') . '</span>')->implode(', ') !!}
                            @else
                                <span class="choice-user">
                                    {{ $choiceMap[$userAnswer] ?? $userAnswer }}
                                </span>
                            @endif
                        </td>

                        <!-- 正誤判定 -->
                        <td class="table-decision">
                            @if ($res['isCorrect'] === null)
                                <p class="active">採点なし</p>
                            @elseif ($res['isCorrect'])
                                <p>○</p>
                            @else
                                <p class="active">×</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <a href="{{ route('user.quizzes.index') }}" class="back-btn result-back">
            一覧へもどる
        </a>

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection
