@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">クイズ一覧</h1>

            <a href="{{ route('admin.quizzes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                新規作成
            </a>

            <table class="table-auto w-full border">
                <thead>
                    <tr>
                        <th class="border px-2 py-1">ID</th>
                        <th class="border px-2 py-1">タイトル</th>
                        <th class="border px-2 py-1">種類</th>
                        <th class="border px-2 py-1">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td class="border px-2 py-1">{{ $quiz->id }}</td>
                            <td class="border px-2 py-1">{{ $quiz->title }}</td>
                            <td class="border px-2 py-1">{{ $types[$quiz->type] ?? '不明' }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="text-blue-600">編集</a>
                                <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 ml-2">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
