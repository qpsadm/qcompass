@extends('layouts.app')

@section('content')
<div class="flex gap-6">

    <!-- 左：親カテゴリ選択 -->
    <div class="w-1/3 bg-white p-4 rounded shadow">
        <h2 class="font-bold mb-3">親カテゴリを選択</h2>

        <ul class="space-y-2">

            {{-- 最上位カテゴリ --}}
            <li>
                <label class="flex items-center gap-2">
                    <input type="radio" name="parent_select" value="" checked>
                    親なし（最上位）
                </label>
            </li>

            {{-- 階層カテゴリ --}}
            @include('admin.categories.partials.category-tree', [
            'categories' => $categories,
            'showActions' => false,
            'radioName' => 'parent_select'
            ])
        </ul>
    </div>

    <!-- 右：新規作成フォーム -->
    <div class="flex-1 p-4 bg-white rounded shadow">
        <h2 class="text-lg font-bold mb-4">新規カテゴリー作成</h2>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4" id="categoryForm">
            @csrf

            {{-- ★ ここが重要：実際に送信される parent_id --}}
            <input type="hidden" name="parent_id" id="selectedParent" value="">

            <div>
                <label class="block mb-1 font-semibold">コード</label>
                <input type="text" name="code" class="w-full border rounded px-3 py-2" value="{{ old('code') }}">
            </div>

            <div>
                <label class="block mb-1 font-semibold">カテゴリー名</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name') }}">
            </div>

            <div>
                <label class="block mb-1 font-semibold">表示フラグ</label>
                <input type="checkbox" name="is_show" value="1" {{ old('is_show') ? 'checked' : '' }}>
            </div>

            <div>
                <label class="block mb-1 font-semibold">テーマカラー</label>
                <select name="theme_color" class="w-full border rounded px-3 py-2">
                    <option value="blue" {{ old('theme_color') == 'blue' ? 'selected' : '' }}>Blue</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">作成</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ★ 親カテゴリラジオをクリック → hidden に設定
        document.querySelectorAll('input[name="parent_select"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('selectedParent').value = this.value;
            });
        });

        // 初期値セット
        const checked = document.querySelector('input[name="parent_select"]:checked');
        if (checked) {
            document.getElementById('selectedParent').value = checked.value;
        }

        // 子カテゴリの折りたたみ
        document.querySelectorAll('.toggle-children').forEach(button => {
            button.addEventListener('click', function() {
                const container = this.closest('li').querySelector('.children-container');
                if (container) container.classList.toggle('hidden');
            });
        });
    });
</script>
@endsection
