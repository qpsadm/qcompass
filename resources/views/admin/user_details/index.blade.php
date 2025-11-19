@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ユーザー詳細一覧</h1>

        <a href="{{ route('admin.user_details.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            新規作成
        </a>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th class="border px-2 py-1">ID</th>
                    <th class="border px-2 py-1">ユーザーID</th>
                    <th class="border px-2 py-1">生年月日</th>
                    <th class="border px-2 py-1">電話番号</th>
                    <th class="border px-2 py-1">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $detail)
                    <tr>
                        <td class="border px-2 py-1">{{ $detail->id }}</td>
                        <td class="border px-2 py-1">{{ $detail->user_id }}</td>
                        <td class="border px-2 py-1">{{ $detail->birthday }}</td>
                        <td class="border px-2 py-1">{{ $detail->phone1 }}</td>
                        <td class="border px-2 py-1">
                            <a href="{{ route('admin.user_details.edit', $detail->id) }}" class="text-blue-500">編集</a>
                            <form action="{{ route('admin.user_details.destroy', $detail->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500" onclick="return confirm('削除しますか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $details->links() }}
    </div>
@endsection
