@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen">

    <div class="bg-white rounded-lg shadow-md p-6 max-w-6xl mx-auto">

        <!-- ヘッダー -->
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">
                ← カテゴリー一覧に戻る
            </a>
            <h1 class="text-2xl font-bold text-gray-800">カテゴリー 作成</h1>
        </div>

        {{-- バリデーションエラー --}}
        @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex gap-6">

            {{-- 左：親カテゴリ選択 --}}
            <div class="w-1/3 bg-gray-50 p-4 rounded-lg border">
                <h2 class="font-semibold mb-3 text-gray-700">親カテゴリを選択</h2>

                <ul class="space-y-2 text-sm">
                    <li>
                        <label class="flex items-center gap-2 cursor-pointer">
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
            <div class="flex-1">

                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" id="selectedParent" value="">

                    <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-sm">
                        <tbody>

                            <!-- コード -->
                            <tr class="border-b">
                                <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium align-middle">
                                    コード
                                    <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                        必須
                                    </span>
                                </th>
                                <td class="px-4 py-3">
                                    <input type="text"
                                        name="code"
                                        value="{{ old('code') }}"
                                        class="border rounded px-3 py-2 w-64
                                                  focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </td>
                            </tr>

                            <!-- カテゴリー名 -->
                            <tr class="border-b">
                                <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium align-middle">
                                    カテゴリー名
                                    <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                        必須
                                    </span>
                                </th>
                                <td class="px-4 py-3">
                                    <input type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        required
                                        class="border rounded px-3 py-2 w-96
                                                  focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </td>
                            </tr>

                            <!-- 表示フラグ -->
                            <tr class="border-b">
                                <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium align-middle">
                                    表示フラグ
                                </th>
                                <td class="px-4 py-3"
                                    x-data="{ is_show: {{ old('is_show', 0) }} }">
                                    <div class="flex gap-2">
                                        <label
                                            :class="is_show == 1
                                                ? 'bg-green-600 text-white'
                                                : 'bg-gray-200 text-gray-700'"
                                            class="px-4 py-2 rounded-full cursor-pointer transition-colors">
                                            <input type="radio"
                                                name="is_show"
                                                value="1"
                                                class="hidden"
                                                x-model="is_show">
                                            公開
                                        </label>

                                        <label
                                            :class="is_show == 0
                                                ? 'bg-red-500 text-white'
                                                : 'bg-gray-200 text-gray-700'"
                                            class="px-4 py-2 rounded-full cursor-pointer transition-colors">
                                            <input type="radio"
                                                name="is_show"
                                                value="0"
                                                class="hidden"
                                                x-model="is_show">
                                            非公開
                                        </label>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <!-- 操作ボタン -->
                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                            作成する
                        </button>

                        <a href="{{ route('admin.categories.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                            一覧に戻る
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    // 親カテゴリ選択を hidden に反映
    document.querySelectorAll('input[name="parent_select"]').forEach(el => {
        el.addEventListener('change', function() {
            document.getElementById('selectedParent').value = this.value;
        });
    });
</script>
@endsection
