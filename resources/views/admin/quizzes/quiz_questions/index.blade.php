@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $quiz->title }} の問題一覧</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.quizzes.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    ← クイズ一覧に戻る
                </a>
                <a href="{{ route('admin.quizzes.quiz_questions.create', $quiz->id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    問題追加
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">問題文</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">選択肢</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">操作</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($quizQuestions as $question)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $question->id }}</td>
                        <td class="px-4 py-2">{{ $question->question_text }}</td>
                        <td class="px-4 py-2">
                            <ul class="list-disc list-inside">
                                @foreach ($question->choices as $choice)
                                <li>
                                    {{ $choice->choice_text }}
                                    @if ($choice->is_correct) <span class="text-green-600 font-bold">✔</span> @endif
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.quizzes.quiz_questions.edit', [$quiz->id, $question->id]) }}"
                                class="text-blue-500 hover:underline">編集</a>
                            <form action="{{ route('admin.quizzes.quiz_questions.destroy', [$quiz->id, $question->id]) }}"
                                method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
