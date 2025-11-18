@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-7xl">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">クイズ一覧</h1>

    <div class="mb-6">
        <a href="{{ route('admin.quizzes.create') }}"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
            新規作成
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">ID</th>
                    <th class="border px-4 py-2 text-left">クイズ名</th>
                    <th class="border px-4 py-2 text-left">種類</th>
                    <th class="border px-4 py-2 text-left">制限時間</th>
                    <th class="border px-4 py-2 text-left">合計点</th>
                    <th class="border px-4 py-2 text-left">公開期間</th>
                    <th class="border px-4 py-2 text-left">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quizzes as $quiz)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $quiz->id }}</td>
                    <td class="border px-4 py-2">{{ $quiz->title }}</td>
                    <td class="border px-4 py-2">{{ $types[$quiz->type] ?? '不明' }}</td>
                    <td class="border px-4 py-2">{{ $quiz->time_limit ?? '-' }} 分</td>
                    <td class="border px-4 py-2">{{ $quiz->total_score ?? '-' }}</td>
                    <td class="border px-4 py-2">
                        {{ $quiz->active_from?->format('Y-m-d H:i') ?? '-' }} ～ {{ $quiz->active_to?->format('Y-m-d H:i') ?? '-' }}
                    </td>
                    <td class="border px-4 py-2 flex gap-2">
                        <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm">編集</a>

                        <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">削除</button>
                        </form>

                        <a href="{{ route('admin.quizzes.take', $quiz) }}" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-sm">受験</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
