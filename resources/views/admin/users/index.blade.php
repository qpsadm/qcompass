@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{ open: false, deleteUrl: '', deleteName: '' }">
    <h1 class="text-2xl font-bold mb-4">ユーザー一覧</h1>

    <a href="{{ route('admin.users.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">
        ＋ 新規ユーザー登録
    </a>

    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ユーザー名・コードで検索"
            class="border px-2 py-1 rounded">
        <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 transition">
            検索
        </button>
    </form>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 w-32">ユーザーコード</th>
                    <th class="border px-4 py-2">氏名</th>
                    <th class="border px-4 py-2">講座ID</th>
                    <th class="border px-4 py-2 w-40 text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $User)
                <tr>
                    <td class="border px-4 py-2">{{ $User->code }}</td>
                    <td class="border px-4 py-2">{{ $User->name }}</td>
                    <td class="border px-4 py-2">{{ $User->course->course_name ?? '未所属' }}</td>
                    <td class="border px-4 py-2 text-center">
                        <a href="{{ route('admin.users.show', $User->id) }}" class="text-green-600 hover:underline">
                            詳細
                        </a>
                        <a href="{{ route('admin.users.edit', $User->id) }}"
                            class="text-blue-600 ml-2 hover:underline">
                            編集
                        </a>
                        <button
                            @click="open = true; deleteUrl = '{{ route('admin.users.destroy', $User->id) }}'; deleteName = '{{ $User->name }}';"
                            class="text-red-600 ml-2 hover:underline">
                            削除
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- ページネーション -->
        <div class="mt-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>

    {{-- ✅ 共通削除モーダル --}}
    <div x-show="open" x-cloak x-transition.opacity.duration.200ms
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div x-show="open" x-transition.scale.duration.200ms
            class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
            <p class="text-gray-700 text-center mb-5">
                「<span x-text="deleteName"></span>」を削除しますか？
            </p>
            <div class="flex justify-center space-x-4">
                <button @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    キャンセル
                </button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        削除する
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{-- /共通削除モーダル --}}
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection
