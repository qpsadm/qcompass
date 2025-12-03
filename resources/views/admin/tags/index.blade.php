@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 pb-24" x-data="{ open: false, deleteName: '', deleteUrl: '' }">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">技術分類タグ一覧</h1>

    {{-- 新規作成 --}}
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('admin.tags.create') }}"
            class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="ml-1 hidden lg:inline">新規作成</span>
        </a>

        {{-- 並び替えボタン --}}
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
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-4 py-2 text-center w-12">No.</th>
                    <th class="border px-4 py-2 text-center w-12">ID</th>
                    <th class="border px-4 py-2 text-center w-24">コード</th>
                    <th class="border px-4 py-2">タグ名</th>
                    <th class="border px-4 py-2 text-center w-20">表示</th>
                    <th class="border px-4 py-2 text-center w-60">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tags as $tag)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">
                        {{ ($tags->currentPage() - 1) * $tags->perPage() + $loop->iteration }}
                    </td>
                    <td class="border px-4 py-2 text-center">{{ $tag->id }}</td>
                    <td class="border px-4 py-2 text-center">{{ $tag->code }}</td>
                    <td class="border px-4 py-2">{{ $tag->name }}</td>
                    <td class="border px-4 py-2 text-center">
                        @if($tag->is_show)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                        @else
                        <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            {{-- 編集 --}}
                            <a href="{{ route('admin.tags.edit', $tag->id) }}"
                                class="flex items-center text-blue-600 hover:text-blue-700">
                                <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">編集</span>
                            </a>

                            {{-- 削除 --}}
                            <button @click="deleteName='{{ $tag->name }}'; deleteUrl='{{ route('admin.tags.destroy', $tag->id) }}'; open=true;"
                                class="flex items-center text-red-600 hover:text-red-700">
                                <img src="{{ asset('assets/images/icon/b_dust.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">削除</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                        データがありません
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ページネーション --}}
    <div class="mt-4">
        {{ $tags->links('pagination::tailwind') }}
    </div>

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

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
@endsection
