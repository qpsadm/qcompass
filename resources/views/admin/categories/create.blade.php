@extends('layouts.app')

@section('content')
    <div class="flex gap-6">

        {{-- 左：親カテゴリ選択 --}}
        <div class="w-1/3 bg-white p-4 rounded shadow">
            <h2 class="font-bold mb-3">親カテゴリを選択</h2>

            <ul class="space-y-2">
                <li>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="parent_select" value="" checked>
                        親なし（最上位）
                    </label>
                </li>

                @include('admin.categories.partials.category-tree', [
                    'categories' => $categories,
                    'showActions' => false,
                    'radioName' => 'parent_select',
                ])
            </ul>
        </div>

        {{-- 右：作成フォーム --}}
        <div class="flex-1 p-4 bg-white rounded shadow">
            <h2 class="text-lg font-bold mb-4">新規カテゴリー作成</h2>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4" id="categoryForm">
                @csrf
                <input type="hidden" name="parent_id" id="selectedParent" value="">

                <div>
                    <label class="block mb-1 font-semibold">コード</label>
                    <input type="text" name="code" class="w-full border rounded px-3 py-2"
                        value="{{ old('code') }}">
                </div>

                <div>
                    <label class="block mb-1 font-semibold">カテゴリー名</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2"
                        value="{{ old('name') }}">
                </div>


   <div class="mb-4" x-data="{ is_show: {{ old('is_show', 0) }} }">
    <span class="font-medium mr-2">表示フラグ</span>
    <div class="flex gap-2">
        <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
            <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
            公開
        </label>

        <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
            <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
            非公開
        </label>
    </div>
</div>


                <div class="flex gap-2 mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        作成
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ラジオボタン選択を hidden に反映
        document.querySelectorAll('input[name="parent_select"]').forEach(el => {
            el.addEventListener('change', function() {
                document.getElementById('selectedParent').value = this.value;
            });
        });
    </script>
@endsection
