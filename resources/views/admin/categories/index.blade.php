@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 pb-24">
    <h1 class="text-2xl font-bold mb-6">カテゴリー一覧</h1>

    <a href="{{ route('admin.categories.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">
        ＋ 新規登録
    </a>

    <div class="bg-white shadow-md rounded-lg p-4">
        <ul class="space-y-2">
            @include('admin.categories.partials.category-tree', [
            'categories' => $categories,
            'showActions' => true,
            'radioName' => null
            ])
        </ul>
    </div>
</div>

<!-- 削除確認モーダル -->
<div id="deleteModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">削除の確認</h2>
        <p class="mb-6">本当に削除しますか？子カテゴリもまとめて削除されます。</p>
        <div class="flex justify-end gap-4">
            <button id="cancelDelete"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                キャンセル
            </button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    削除
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
