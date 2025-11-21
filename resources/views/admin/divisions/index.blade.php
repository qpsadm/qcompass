@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">部署一覧</h1>
        <a href="{{ route('admin.divisions.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded">新規作成</a>
    </div>

    @if (session('success'))
    <p class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</p>
    @endif

    <table class="min-w-full bg-white border">
        <thead class="bg-gray-200">
            <tr>
                <th class="border p-2">コード</th>
                <th class="border p-2">部署名</th>
                <th class="border p-2">表示</th>
                <th class="border p-2">操作</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($divisions as $division)
            <tr>
                <td class="border p-2">{{ $division->code }}</td>
                <td class="border p-2">{{ $division->name }}</td>
                <td class="border p-2">{{ $division->is_show ? '✔' : '✖' }}</td>

                <td class="border p-2">
                    <a href="{{ route('admin.divisions.edit', $division->id) }}"
                        class="text-blue-600">編集</a>

                    <form action="{{ route('admin.divisions.destroy', $division->id) }}"
                        method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 ml-2"
                            onclick="return confirm('削除しますか？')">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
