@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{ open: false, deleteUrl: '', deleteName: '' }">

    <!-- タイトル -->
    <h1 class="text-2xl font-bold mb-4">ゴミ箱カテゴリ一覧</h1>
    <a href="{{ route('admin.categories.index') }}"
        class="inline-block mb-4 px-4 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 transition">
        一覧へ戻る
    </a>

    <!-- カテゴリリスト -->
    <div class="bg-white shadow-md rounded-lg p-4 overflow-x-auto">
        <ul class="space-y-2">
            @forelse ($categories as $category)
            <li class="flex items-center justify-between bg-white rounded-md shadow-sm py-2 px-3 hover:bg-gray-50">

                <!-- カテゴリ情報 -->
                <div class="flex flex-col">
                    <span class="font-medium text-gray-800">名前: {{ $category->name }}</span>
                    <span class="text-xs text-gray-500">
                        ID: {{ $category->id }} / コード: {{ $category->code }}
                    </span>
                </div>

                <!-- 操作ボタン -->
                <div class="flex items-center gap-2">
                    <!-- 復元 -->
                    <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600 transition">
                            復活
                        </button>
                    </form>
                </div>
            </li>
            @empty
            <li class="text-center text-gray-500 py-4">
                データがありません
            </li>
            @endforelse
        </ul>
    </div>

    <!-- 共通削除モーダル -->
    <div
        x-show="open"
        x-cloak
        x-transition.opacity.duration.200ms
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div x-show="open" x-transition.scale.duration.200ms class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
            <p class="text-gray-700 text-center mb-5">
                「<span x-text="deleteName"></span>」を完全削除しますか？
            </p>
            <div class="flex justify-center space-x-4">
                <button
                    @click="open = false"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                    キャンセル
                </button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                        完全削除
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection
