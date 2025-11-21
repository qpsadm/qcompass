@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">クイズ結果</h1>

    <div class="mb-4">
        <p><strong>ユーザー:</strong> {{ $attempt->user->name }}</p>
        <p><strong>クイズ:</strong> {{ $attempt->quiz->title }}</p>
        <p><strong>総問題数:</strong> {{ $totalQuestions }}</p>
        <p><strong>正解数:</strong> {{ $totalCorrect }}</p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">問題</th>
                    <th class="px-4 py-2 border">選択肢</th>
                    <th class="px-4 py-2 border">あなたの回答</th>
                    <th class="px-4 py-2 border">正解</th>
                    <th class="px-4 py-2 border">結果</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attempt->quiz->quizQuestions as $index => $question)
                @php
                $userAnswer = $attempt->answers->firstWhere('question_id', $question->id);
                $correctChoice = $question->choices->firstWhere('is_correct', 1);
                $isCorrect = $userAnswer && $correctChoice && $userAnswer->choice_id == $correctChoice->id;
                @endphp
                <tr class="{{ $isCorrect ? 'bg-green-100' : 'bg-red-100' }}">
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border">{{ $question->question_text }}</td>
                    <td class="px-4 py-2 border">
                        <ul class="list-disc pl-5">
                            @foreach($question->choices as $choice)
                            <li>{{ $choice->choice_text }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $userAnswer ? $userAnswer->choice->choice_text : '未回答' }}
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $correctChoice ? $correctChoice->choice_text : '未設定' }}
                    </td>
                    <td class="px-4 py-2 border font-bold">
                        {{ $isCorrect ? '正解' : '不正解' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.quizzes.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">戻る</a>
    </div>
</div>
@endsection
