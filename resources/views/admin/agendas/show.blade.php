@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen"
    x-data="{ deleteOpen: false }">

    <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">

        <!-- ヘッダー -->
        <div class="mb-6">
            <a href="{{ route('admin.agendas.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">
                ← アジェンダ一覧に戻る
            </a>
            <h1 class="text-2xl font-bold text-gray-800">
                アジェンダ詳細
            </h1>
        </div>

        <!-- 詳細テーブル -->
        <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-sm">
            <tbody>
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium">
                        アジェンダ名
                    </th>
                    <td class="px-4 py-3">
                        {{ $agenda->agenda_name }}
                    </td>
                </tr>

                <tr class="border-b">
                    <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                        カテゴリ
                    </th>
                    <td class="px-4 py-3">
                        {{ $agenda->category?->name ?? '未設定' }}
                    </td>
                </tr>

                <tr class="border-b">
                    <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                        表示フラグ
                    </th>
                    <td class="px-4 py-3">
                        {{ $agenda->is_show ? '表示' : '非表示' }}
                    </td>
                </tr>

                <tr class="border-b">
                    <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                        承認状態
                    </th>
                    <td class="px-4 py-3">
                        {{ $agenda->status === 'yes' ? '承認済み' : '下書き' }}
                    </td>
                </tr>

                <tr class="border-b">
                    <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                        作成者
                    </th>
                    <td class="px-4 py-3">
                        {{ $agenda->created_user_name ?? '不明' }}
                    </td>
                </tr>

                <tr>
                    <th class="px-4 py-3 bg-gray-100 text-right font-medium">
                        更新者
                    </th>
                    <td class="px-4 py-3">
                        {{ $agenda->updated_user_name ?? 'なし' }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 操作ボタン -->
        <div class="mt-6 flex gap-3">
            <button type="button"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded preview-button"
                data-content='@json($agenda->content)'
                data-title="{{ $agenda->agenda_name }}">
                プレビュー
            </button>

            <a href="{{ route('admin.agendas.edit', $agenda->id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                編集
            </a>

            <a href="{{ route('admin.agendas.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                一覧に戻る
            </a>
        </div>

        <!-- 危険操作ゾーン -->
        <div class="mt-10 pt-6 border-t border-red-200">
            <h2 class="text-red-600 font-semibold mb-2">
                ⚠ 危険な操作
            </h2>

            <p class="text-sm text-gray-600 mb-4">
                このアジェンダを削除すると、元に戻すことはできません。
            </p>

            <button
                @click="deleteOpen = true"
                class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                削除する
            </button>
        </div>
    </div>

    <!-- 削除確認モーダル -->
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
                「<span class="font-semibold">{{ $agenda->agenda_name }}</span>」を削除しますか？
            </p>

            <div class="flex justify-center gap-4">
                <button
                    @click="deleteOpen = false"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    キャンセル
                </button>

                <form action="{{ route('admin.agendas.destroy', $agenda->id) }}"
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

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/previewWindow.js') }}"></script>
@endsection
