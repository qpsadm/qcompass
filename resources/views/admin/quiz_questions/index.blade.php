@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">{{ $quiz->title }} の問題一覧</h1>

    <!-- 問題追加リンク -->
    <a href="{{ route('admin.quizzes.quiz_questions.create', $quiz->id) }}"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        問題追加
    </a>

    <table class="mt-4 w-full border">
        <thead>
            <tr>
                <th class="border px-2 py-1">ID</th>
                <th class="border px-2 py-1">問題文</th>
                <th class="border px-2 py-1">選択肢</th>
                <th class="border px-2 py-1">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quizQuestions as $question)
            <tr>
                <td class="border px-2 py-1">{{ $question->id }}</td>
                <td class="border px-2 py-1">{{ $question->question_text }}</td>
                <td class="border px-2 py-1">
                    <ul>
                        @foreach($question->choices as $choice)
                        <li>{{ $choice->choice_text }} @if($choice->is_correct)✔@endif</li>
                        @endforeach
                    </ul>
                </td>
                <td class="border px-2 py-1">
                    <a href="{{ route('admin.quizzes.quiz_questions.edit', [$quiz->id, $question->id]) }}"
                        class="text-blue-500">編集</a>
                    <form action="{{ route('admin.quizzes.quiz_questions.destroy', [$quiz->id, $question->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
