@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">実績一覧</h1>
        <a href="{{ route('achievements.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

        <table class="table-auto border-collapse border w-full">
            <thead>
                <tr>
                    <th class='border px-4 py-2'>実績名</th>
                    <th class='border px-4 py-2'>条件説明</th>
                    <th class='border px-4 py-2'>達成条件タイプ</th>
                    <th class='border px-4 py-2'>条件値</th>
                    <th class='border px-4 py-2'>削除日</th>

                    <th class='border px-4 py-2'>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($achievements as $Achievement)
                    <tr>
                        <td class='border px-4 py-2'>{{ $Achievement->title }}</td>
                        <td class='border px-4 py-2'>{{ $Achievement->description }}</td>
                        <td class='border px-4 py-2'>{{ $Achievement->condition_type }}</td>
                        <td class='border px-4 py-2'>{{ $Achievement->condition_value }}</td>
                        <td class='border px-4 py-2'>{{ $Achievement->deleted_at }}</td>

                        <td class='border px-4 py-2'>
                            <a href="{{ route('achievements.show', $Achievement->id) }}" class="text-green-600">詳細</a>
                            <a href="{{ route('achievements.edit', $Achievement->id) }}" class="text-blue-600 ml-2">編集</a>
                            <form action="{{ route('achievements.destroy', $Achievement->id) }}" method="POST"
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
