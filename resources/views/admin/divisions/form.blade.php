@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen"
    x-data="{ deleteOpen: false }">

    <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">

        <!-- ヘッダー -->
        <div class="mb-6">
            <a href="{{ route('admin.divisions.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">
                ← 部署一覧に戻る
            </a>
            <h1 class="text-2xl font-bold text-gray-800">
                {{ isset($division) ? '部署 編集' : '部署 新規作成' }}
            </h1>
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

        <!-- 保存フォーム -->
        <form
            action="{{ isset($division)
                ? route('admin.divisions.update', $division->id)
                : route('admin.divisions.store') }}"
            method="POST">
            @csrf
            @isset($division)
            @method('PUT')
            @endisset

            <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-sm">
                <tbody>
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium">
                            部署コード
                        </th>
                        <td class="px-4 py-3">
                            <input type="text" name="code"
                                value="{{ old('code', $division->code ?? '') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                            部署名
                            <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                必須
                            </span>
                        </th>
                        <td class="px-4 py-3">
                            <input type="text" name="name"
                                value="{{ old('name', $division->name ?? '') }}"
                                class="border rounded px-3 py-2 w-64"
                                required>
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                            電話番号
                        </th>
                        <td class="px-4 py-3">
                            <input type="text" name="tel"
                                value="{{ old('tel', $division->tel ?? '') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                            郵便番号
                        </th>
                        <td class="px-4 py-3">
                            <input type="text" name="post_code"
                                value="{{ old('post_code', $division->post_code ?? '') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                            住所
                        </th>
                        <td class="px-4 py-3">
                            <input type="text" name="address"
                                value="{{ old('address', $division->address ?? '') }}"
                                class="border rounded px-3 py-2 w-full">
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                            表示フラグ
                        </th>
                        <td class="px-4 py-3"
                            x-data="{ is_show: '{{ old('is_show', $division->is_show ?? 1) }}' }">
                            <div class="flex gap-2">
                                <label
                                    :class="is_show == 1
                                        ? 'bg-green-600 text-white'
                                        : 'bg-gray-200 text-gray-700'"
                                    class="px-4 py-2 rounded-full cursor-pointer">
                                    <input type="radio" name="is_show" value="1"
                                        class="hidden" x-model="is_show">
                                    公開
                                </label>

                                <label
                                    :class="is_show == 0
                                        ? 'bg-red-500 text-white'
                                        : 'bg-gray-200 text-gray-700'"
                                    class="px-4 py-2 rounded-full cursor-pointer">
                                    <input type="radio" name="is_show" value="0"
                                        class="hidden" x-model="is_show">
                                    非公開
                                </label>
                            </div>
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                            備考
                        </th>
                        <td class="px-4 py-3">
                            <textarea name="memo"
                                class="border rounded px-3 py-2 w-64">{{ old('memo', $division->memo ?? '') }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- 操作ボタン -->
            <div class="mt-6 flex gap-3">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    保存
                </button>

                <a href="{{ route('admin.divisions.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>

        <!-- 危険操作ゾーン（編集時のみ） -->
        @isset($division)
        <div class="mt-10 pt-6 border-t border-red-200">
            <h2 class="text-red-600 font-semibold mb-2">
                ⚠ 危険な操作
            </h2>

            <p class="text-sm text-gray-600 mb-4">
                この部署を削除すると、元に戻すことはできません。
            </p>

            <button
                @click="deleteOpen = true"
                class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                削除する
            </button>
        </div>
        @endisset
    </div>

    <!-- 削除確認モーダル -->
    @isset($division)
    <div x-show="deleteOpen"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div x-show="deleteOpen"
            x-transition.scale
            class="bg-white rounded-2xl p-6 w-full max-w-sm">

            <h3 class="text-lg font-semibold text-center mb-3">
                削除確認
            </h3>

            <p class="text-center text-gray-700 mb-5">
                「<span class="font-semibold">{{ $division->name }}</span>」を削除しますか？
            </p>

            <div class="flex justify-center gap-4">
                <button
                    @click="deleteOpen = false"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    キャンセル
                </button>

                <form action="{{ route('admin.divisions.destroy', $division->id) }}"
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
    @endisset

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
@endsection
