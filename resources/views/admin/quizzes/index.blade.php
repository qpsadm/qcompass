@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-7xl bg-white rounded-lg shadow-md" x-data="{ open: false, deleteName: '', deleteUrl: '' }">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">クイズ一覧</h1>

    <div class="mb-6">
        <a href="{{ route('admin.quizzes.create') }}"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
            新規作成
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class='border px-4 py-2 text-left'>クイズコード</th>
                    <th class='border px-4 py-2 text-left'>クイズ名</th>
                    <th class='border px-4 py-2 text-left'>問題タイプ</th>
                    <th class='border px-4 py-2 text-left'>制限時間</th>
                    <th class='border px-4 py-2 text-left'>合計点</th>
                    <th class='border px-4 py-2 text-left'>操作</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($quizzes as $Quiz)
                <tr>
                    <td class='border px-4 py-2'>{{ $Quiz->code }}</td>
                    <td class='border px-4 py-2'>{{ $Quiz->title }}</td>
                    <td class='border px-4 py-2'>{{ $Quiz->type }}</td>
                    <td class='border px-4 py-2'>{{ $Quiz->time_limit }}</td>
                    <td class='border px-4 py-2'>{{ $Quiz->total_score }}</td>
                    <td class='border px-4 py-2 space-x-2'>
                        <a href="{{ route('admin.quizzes.show', $Quiz->id) }}"
                            class="text-green-600 hover:underline">詳細</a>
                        <a href="{{ route('admin.quizzes.edit', $Quiz->id) }}"
                            class="text-blue-600 hover:underline">編集</a>
                        <button @click="open = true; deleteName='{{ $Quiz->title }}'; deleteUrl='{{ route('admin.quizzes.destroy', $Quiz->id) }}'"
                            class="text-red-600 hover:underline">削除</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- 共通削除モーダル --}}
    <div x-show="open" x-cloak x-transition.opacity.duration.200ms
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div x-show="open" x-transition.scale.duration.200ms
            class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
            <p class="text-gray-700 text-center mb-5">
                「<span x-text="deleteName"></span>」を削除しますか？
            </p>
            <div class="flex justify-center space-x-4">
                <button @click="open = false"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">キャンセル</button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">削除する</button>
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
