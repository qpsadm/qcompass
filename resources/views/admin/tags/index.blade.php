@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 pb-24"> {{-- pb-24 でフッター分の余白 --}}
        <h1 class="text-2xl font-bold mb-6">技術分類タグ一覧</h1>

        {{-- 新規作成 --}}
        <a href="{{ route('admin.tags.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">
            ＋ 新規作成
        </a>

        {{-- 並び替えボタン --}}
        <div class="mb-4 flex justify-end">
            @php
                $order = request('order', 'desc');
                $toggleOrder = $order === 'desc' ? 'asc' : 'desc';
            @endphp
            <a href="{{ route('admin.tags.index', ['order' => $toggleOrder]) }}"
                class="bg-gray-100 hover:bg-gray-200 border border-gray-300 px-3 py-1.5 rounded text-sm font-medium shadow-sm">
                並び替え：{{ $order === 'desc' ? '昇順' : '降順' }}
            </a>
        </div>

        {{-- タグ一覧テーブル --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left text-gray-700">
                        <th class="border-b px-4 py-2 text-center w-1/12">ID</th>
                        <th class="border-b px-4 py-2 text-center w-1/6">コード</th>
                        <th class="border-b px-4 py-2">タグ名</th>
                        <th class="border-b px-4 py-2 text-center w-1/12">表示</th>
                        <th class="border-b px-4 py-2 text-center w-1/6">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $tag)
                        <tr class="hover:bg-gray-50" x-data="{ open: false, deleteName: '', deleteUrl: '' }">
                            <td class="border-b px-4 py-2 text-center">{{ $tag->id }}</td>
                            <td class="border-b px-4 py-2 text-center">{{ $tag->code }}</td>
                            <td class="border-b px-4 py-2">{{ $tag->name }}</td>
                            <td class="border-b px-4 py-2 text-center">{{ $tag->is_show ? '表示' : '非表示' }}</td>
                            <td class="border-b px-4 py-2 text-center flex justify-center gap-2">
                                {{-- 編集 --}}
                                <a href="{{ route('admin.tags.edit', $tag->id) }}"
                                    class="text-blue-500 hover:underline">編集</a>

                                {{-- 削除 --}}
                                <button
                                    @click="deleteName='{{ $tag->name }}'; deleteUrl='{{ route('admin.tags.destroy', $tag->id) }}'; open=true;"
                                    class="text-red-500 hover:underline bg-transparent p-0">
                                    削除
                                </button>

                                {{-- 共通削除モーダル --}}
                                <div x-show="open" x-cloak x-transition.opacity.duration.200ms
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                    <div x-show="open" x-transition.scale.duration.200ms
                                        class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                                        <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                                        <p class="text-gray-700 text-center mb-5">
                                            「<span x-text="deleteName"></span>」を削除しますか？
                                        </p>
                                        <div class="flex justify-center space-x-4">
                                            <button @click="open = false"
                                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                                                キャンセル
                                            </button>
                                            <form :action="deleteUrl" method="POST">
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
                                {{-- /共通削除モーダル --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">データがありません</td>
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
