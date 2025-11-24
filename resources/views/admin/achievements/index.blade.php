@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{ open: false, deleteUrl: '', deleteName: '' }">
    <h1 class="text-2xl font-bold mb-4">実績一覧</h1>

    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('admin.achievements.create') }}" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 text-white flex items-center space-x-1">
            <span>新規作成</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">実績名</th>
                    <th class="border px-4 py-2">条件説明</th>
                    <th class="border px-4 py-2">達成条件タイプ</th>
                    <th class="border px-4 py-2">条件値</th>
                    <th class="border px-4 py-2 text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($achievements as $Achievement)
                <tr>
                    <td class="border px-4 py-2">{{ $Achievement->title }}</td>
                    <td class="border px-4 py-2">{{ $Achievement->description }}</td>
                    <td class="border px-4 py-2">
                        @switch($Achievement->condition_type)
                        @case('attendance') 出席 @break
                        @case('score') 点数 @break
                        @case('report') レポート @break
                        @case('custom') カスタム @break
                        @default 不明
                        @endswitch
                    </td>
                    <td class="border px-4 py-2">{{ $Achievement->condition_value }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.achievements.show', $Achievement->id) }}" class="text-green-600">詳細</a>
                            <a href="{{ route('admin.achievements.edit', $Achievement->id) }}" class="text-blue-600 ml-2">編集</a>
                            <button @click="open = true; deleteUrl='{{ route('admin.achievements.destroy', $Achievement->id) }}'; deleteName='{{ $Achievement->title }}';"
                                class="text-red-600 ml-2">削除</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- 削除モーダル --}}
    <div x-show="open" x-cloak x-transition.opacity.duration.200ms class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div x-show="open" x-transition.scale.duration.200ms class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
            <p class="text-gray-700 text-center mb-5">
                「<span x-text="deleteName"></span>」を削除しますか？
            </p>
            <div class="flex justify-center space-x-4">
                <button @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">キャンセル</button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">削除する</button>
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
