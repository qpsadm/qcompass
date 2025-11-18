@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">クイズ集計一覧</h1>
        <a href="{{ route('quiz_statistics.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

        <table class="table-auto border-collapse border w-full">
            <thead>
                <tr>
                    <th class='border px-4 py-2'>クイズID</th>
                    <th class='border px-4 py-2'>平均点</th>
                    <th class='border px-4 py-2'>最高点</th>
                    <th class='border px-4 py-2'>受験者数</th>

                    <th class='border px-4 py-2'>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quiz_statistics as $QuizStatistic)
                    <tr>
                        <td class='border px-4 py-2'>{{ $QuizStatistic->quiz_id }}</td>
                        <td class='border px-4 py-2'>{{ $QuizStatistic->average_score }}</td>
                        <td class='border px-4 py-2'>{{ $QuizStatistic->highest_score }}</td>
                        <td class='border px-4 py-2'>{{ $QuizStatistic->attempts_count }}</td>

                        <td class='border px-4 py-2'>
                            <a href="{{ route('quiz_statistics.show', $QuizStatistic->id) }}" class="text-green-600">詳細</a>
                            <a href="{{ route('quiz_statistics.edit', $QuizStatistic->id) }}"
                                class="text-blue-600 ml-2">編集</a>
                            <form action="{{ route('quiz_statistics.destroy', $QuizStatistic->id) }}" method="POST"
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
