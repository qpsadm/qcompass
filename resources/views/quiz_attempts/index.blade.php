@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">受験履歴一覧</h1>
        <a href="{{ route('quiz_attempts.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

        <table class="table-auto border-collapse border w-full">
            <thead>
                <tr>
                    <th class='border px-4 py-2'>受験者ID</th>
                    <th class='border px-4 py-2'>クイズID</th>
                    <th class='border px-4 py-2'>開始時刻</th>
                    <th class='border px-4 py-2'>終了時刻</th>
                    <th class='border px-4 py-2'>得点</th>
                    <th class='border px-4 py-2'>状態</th>
                    <th class='border px-4 py-2'>受験回数</th>
                    <th class='border px-4 py-2'>受験環境記録※任意※</th>

                    <th class='border px-4 py-2'>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quiz_attempts as $QuizAttempt)
                    <tr>
                        <td class='border px-4 py-2'>{{ $QuizAttempt->user_id }}</td>
                        <td class='border px-4 py-2'>{{ $QuizAttempt->quiz_id }}</td>
                        <td class='border px-4 py-2'>{{ $QuizAttempt->started_at }}</td>
                        <td class='border px-4 py-2'>{{ $QuizAttempt->completed_at }}</td>
                        <td class='border px-4 py-2'>{{ $QuizAttempt->score }}</td>
                        <td class='border px-4 py-2'>{{ $QuizAttempt->status }}</td>
                        <td class='border px-4 py-2'>{{ $QuizAttempt->attempt_no }}</td>
                        <td class='border px-4 py-2'>{{ $QuizAttempt->ip_address }}</td>

                        <td class='border px-4 py-2'>
                            <a href="{{ route('quiz_attempts.show', $QuizAttempt->id) }}" class="text-green-600">詳細</a>
                            <a href="{{ route('quiz_attempts.edit', $QuizAttempt->id) }}" class="text-blue-600 ml-2">編集</a>
                            <form action="{{ route('quiz_attempts.destroy', $QuizAttempt->id) }}" method="POST"
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
