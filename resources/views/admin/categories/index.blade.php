@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 pb-24">
        <h1 class="text-2xl font-bold mb-6">カテゴリー一覧</h1>

        <a href="{{ route('admin.categories.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">
            ＋ 新規登録
        </a>
        <a href="{{ route('admin.categories.trash') }}" class="ml-4 text-red-500 underline">ゴミ箱</a>

        <div class="bg-white shadow-md rounded-lg p-4">
            @include('admin.categories.partials.category-tree', ['categories' => $categories])
        </div>
    </div>

    {{-- 削除モーダル --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">削除の確認</h2>
            <p class="mb-6" id="deleteMessage">本当に削除しますか？</p>
            <div class="flex justify-end gap-4">
                <button id="cancelDelete" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">キャンセル</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">削除</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(id, name) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const message = document.getElementById('deleteMessage');

            form.action = "{{ url('admin/categories') }}/" + id;
            message.textContent = `「${name}」を本当に削除しますか？`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
@endsection
