@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">

            <h1 class="text-2xl font-bold mb-4">解答一覧</h1>
            <a href="{{ route('quiz_answers.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

            <table class="table-auto border-collapse border w-full">
                <thead>
                    <tr>
                        <th class='border px-4 py-2'>紐づく受験履歴ID</th>
                        <th class='border px-4 py-2'>設問ID</th>
                        <th class='border px-4 py-2'>選択肢ID</th>
                        <th class='border px-4 py-2'>自由解答時の内容</th>
                        <th class='border px-4 py-2'>正誤判定</th>
                        <th class='border px-4 py-2'>採点後のスコア</th>

                        <th class='border px-4 py-2'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quiz_answers as $QuizAnswer)
                        <tr>
                            <td class='border px-4 py-2'>{{ $QuizAnswer->attempt_id }}</td>
                            <td class='border px-4 py-2'>{{ $QuizAnswer->question_id }}</td>
                            <td class='border px-4 py-2'>{{ $QuizAnswer->choice_id }}</td>
                            <td class='border px-4 py-2'>{{ $QuizAnswer->answer_text }}</td>
                            <td class='border px-4 py-2'>{{ $QuizAnswer->is_correct }}</td>
                            <td class='border px-4 py-2'>{{ $QuizAnswer->score }}</td>

                            <td class='border px-4 py-2'>
                                <a href="{{ route('quiz_answers.show', $QuizAnswer->id) }}" class="text-green-600">詳細</a>
                                <a href="{{ route('quiz_answers.edit', $QuizAnswer->id) }}"
                                    class="text-blue-600 ml-2">編集</a>
                                <form action="{{ route('quiz_answers.destroy', $QuizAnswer->id) }}" method="POST"
                                    class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
