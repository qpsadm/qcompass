@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen" x-data="{ deleteOpen: false }">

    <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">

        <!-- ヘッダー -->
        <div class="mb-6">
            <a href="{{ route('admin.announcement_types.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">
                ← カテゴリ一覧に戻る
            </a>
            <h1 class="text-2xl font-bold text-gray-800">お知らせカテゴリ 編集</h1>
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

        <!-- 編集フォーム -->
        <form method="POST" action="{{ route('admin.announcement_types.update', $type->id) }}">
            @csrf
            @method('PUT')

            <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-sm">
                <tbody>
                    @include('admin.announcement_types.form', ['type' => $type])
                </tbody>
            </table>

            <!-- 操作ボタン -->
            <div class="mt-6 flex gap-3">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    更新する
                </button>
                <a href="{{ route('admin.announcement_types.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>

        <!-- 危険操作ゾーン -->
        <div class="mt-10 pt-6 border-t border-red-200">
            <h2 class="text-red-600 font-semibold mb-2 flex items-center">
                ⚠ 危険な操作
            </h2>

            <p class="text-sm text-gray-600 mb-4">
                このカテゴリを削除すると、元に戻すことはできません。
            </p>

            <button
                @click="deleteOpen = true"
                class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                削除する
            </button>
        </div>

    </div>

    <!-- 削除確認モーダル -->
    <div x-show="deleteOpen" x-cloak x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div x-show="deleteOpen" x-transition.scale
            class="bg-white rounded-2xl p-6 w-full max-w-sm">

            <h3 class="text-lg font-semibold text-center mb-3">
                削除確認
            </h3>

            <p class="text-center text-gray-700 mb-5">
                「<span class="font-semibold">{{ $type->type_name }}</span>」を削除しますか？<br>
                <span class="text-sm text-red-600">※ この操作は取り消せません</span>
            </p>

            <div class="flex justify-center gap-4">
                <button
                    @click="deleteOpen = false"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    キャンセル
                </button>

                <form method="POST"
                    action="{{ route('admin.announcement_types.destroy', $type->id) }}">
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

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
@endsection
