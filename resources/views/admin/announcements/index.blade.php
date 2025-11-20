@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">お知らせ一覧</h1>

    <a href="{{ route('admin.announcements.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">新規作成</a>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr class="bg-gray-200">
                <th>ID</th>
                <th>タイトル</th>
                <th>カテゴリ</th>
                <th>講座</th>
                <th>表示</th>
                <th>状態</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($announcements as $item)
            <tr class="border-b">
                <td>{{ $item->id }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->type->type_name ?? '-' }}</td>
                <td>{{ $item->course->name ?? '-' }}</td>
                <td>{{ $item->is_show ? '表示' : '非表示' }}</td>
                <td>{{ $item->status }}</td>
                <td class="space-x-2">
                    <a href="{{ route('admin.announcements.edit', $item->id) }}" class="text-blue-500">編集</a>

                    <form action="{{ route('admin.announcements.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500" onclick="return confirm('削除しますか？')">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $announcements->links() }}
    </div>
</div>
@endsection
