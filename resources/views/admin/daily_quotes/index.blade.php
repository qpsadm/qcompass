@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">今日の一言一覧</h1>

        {{-- 新規作成 --}}
        <a href="{{ route('admin.daily_quotes.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">
            新規作成
        </a>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left text-gray-700">
                        <th class="border-b px-4 py-2">ひとこと本文</th>
                        <th class="border-b px-4 py-2">発言者・出典</th>
                        <th class="border-b px-4 py-2">特定日用</th>
                        <th class="border-b px-4 py-2">表示フラグ</th>
                        <th class="border-b px-4 py-2 text-center w-1/4">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daily_quotes as $quote)
                        <tr x-data="{ open: false }" class="hover:bg-gray-50">
                            <td class="border-b px-4 py-2">{{ $quote->quote }}</td>
                            <td class="border-b px-4 py-2">{{ $quote->author }}</td>
                            <td class="border-b px-4 py-2">{{ $quote->display_date }}</td>
                            <td class="border-b px-4 py-2">{{ $quote->is_show }}</td>
                            <td class="border-b px-4 py-2 text-center flex justify-center gap-2">
                                <a href="{{ route('admin.daily_quotes.show', $quote->id) }}"
                                    class="text-green-500 hover:underline">詳細</a>
                                <a href="{{ route('admin.daily_quotes.edit', $quote->id) }}"
                                    class="text-blue-500 hover:underline">編集</a>

                                {{-- 削除ボタン --}}
                                <button @click="open = true" class="text-red-500 hover:underline bg-transparent p-0">
                                    削除
                                </button>

                                {{-- モーダル --}}
                                <div x-show="open" x-cloak x-transition.opacity.duration.200ms
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                    <div x-show="open" x-transition.scale.duration.200ms
                                        class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                                        <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                                        <p class="text-gray-700 text-center mb-5">
                                            「{{ $quote->quote }}」を削除しますか？
                                        </p>
                                        <div class="flex justify-center gap-4">
                                            <button @click="open = false"
                                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                                                キャンセル
                                            </button>
                                            <form action="{{ route('admin.daily_quotes.destroy', $quote->id) }}"
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">データがありません</td>
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
