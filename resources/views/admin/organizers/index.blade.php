@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">        <h1 class="text-2xl font-bold mb-6">開催者一覧</h1>

        {{-- 新規作成ボタン --}}
        <a href="{{ route('admin.organizers.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">
            ＋ 新規作成
        </a>

        {{-- Organizer テーブル --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100 text-gray-700 text-left">
                    <tr>
                        <th class="border-b px-4 py-2">開催者名</th>
                        <th class="border-b px-4 py-2 text-center w-1/4">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($organizer as $Organizer)
                        <tr class="hover:bg-gray-50" x-data="{ open: false }">
                            <td class="border-b px-4 py-2">{{ $Organizer->name }}</td>
                            <td class="border-b px-4 py-2 text-center flex justify-center gap-2">

                                {{-- 編集 --}}
                                <a href="{{ route('admin.organizers.edit', $Organizer->id) }}"
                                    class="text-blue-600 hover:underline">編集</a>

                                {{-- 削除 --}}
                                <button @click="open = true" class="text-red-600 hover:underline bg-transparent p-0">
                                    削除
                                </button>

                                {{-- 削除モーダル --}}
                                <div x-show="open" x-cloak x-transition.opacity.duration.200ms
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                    <div x-show="open" x-transition.scale.duration.200ms
                                        class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                                        <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                                        <p class="text-gray-700 text-center mb-5">
                                            「{{ $Organizer->name }}」を削除しますか？
                                        </p>
                                        <div class="flex justify-center space-x-4">
                                            <button @click="open = false"
                                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                                                キャンセル
                                            </button>
                                            <form action="{{ route('admin.organizers.destroy', $Organizer->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                                    削除する
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- /削除モーダル --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-gray-500 py-4">データがありません</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- x-cloak 用 --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
