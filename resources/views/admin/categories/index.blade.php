@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md"
    x-data="{ open: false, deleteUrl: '', deleteName: '' }"
    x-on:open-delete.window="
         deleteUrl = $event.detail.url;
         deleteName = $event.detail.name;
         open = true;
     ">

    <h1 class="text-2xl font-bold mb-4">カテゴリー一覧</h1>

    <div class="flex items-center mb-4 space-x-2">
        <a href="{{ route('admin.categories.create') }}"
            class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">新規登録</span>
        </a>

        <a href="{{ route('admin.categories.trash') }}"
            class="bg-red-100 px-4 py-2 rounded hover:bg-red-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_dustbox.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">ゴミ箱</span>
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-4 overflow-x-auto">
        @include('admin.categories.partials.category-tree', ['categories' => $categories])
    </div>

    <!-- 共通削除モーダル -->
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
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection
