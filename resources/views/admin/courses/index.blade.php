@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 pb-24 max-w-6xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">講座一覧</h1>

            {{-- 上部操作 --}}
            <div class="flex justify-between mb-4">
                <a href="{{ route('admin.courses.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
                    新規作成
                </a>

                <form method="GET" action="{{ route('admin.courses.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="講座コード・講座名・主催者で検索"
                        class="border px-3 py-1 rounded flex-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 transition">検索</button>
                </form>
            </div>

<<<<<<< HEAD
            {{-- カード風テーブル --}}
            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table class="w-full table-auto border border-gray-200">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="border px-4 py-2">講座コード</th>
                            <th class="border px-4 py-2">分野</th>
                            <th class="border px-4 py-2">種類</th>
                            <th class="border px-4 py-2">主催者名</th>
                            <th class="border px-4 py-2">講座名</th>
                            <th class="border px-4 py-2">認定番号</th>
                            <th class="border px-4 py-2">状態</th>
                            <th class="border px-4 py-2">作成日</th>
                            <th class="border px-4 py-2">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $Course)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="border px-4 py-2">{{ $Course->course_code }}</td>
                                <td class="border px-4 py-2">{{ $Course->courseType->name ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $Course->level->name ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $Course->organizer->name ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $Course->course_name }}</td>
                                <td class="border px-4 py-2">{{ $Course->certification_number }}</td>
                                <td class="border px-4 py-2">{{ $Course->status }}</td>
                                <td class="border px-4 py-2">{{ $Course->created_at->format('Y-m-d') }}</td>
                                <td class="border px-4 py-2 flex gap-2 items-center">
                                    <a href="{{ route('admin.courses.show', $Course->id) }}"
                                        class="text-green-600 hover:text-green-400">詳細</a>
                                    <a href="{{ route('admin.courses.edit', $Course->id) }}"
                                        class="text-blue-600 hover:text-blue-400">編集</a>
=======
        <table class="table-auto border-collapse border w-full">
            <thead>
                <tr>
                    <th class="border px-4 py-2">講座コード</th>
                    <th class="border px-4 py-2">分野</th>
                    <th class="border px-4 py-2">種類</th>
                    <th class="border px-4 py-2">主催者名</th>
                    <th class="border px-4 py-2">講座名</th>
                    <th class="border px-4 py-2">認定番号</th>
                    <th class="border px-4 py-2">状態</th>
                    <th class="border px-4 py-2">作成日</th>
                    <th class="border px-4 py-2">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $Course)
                    <tr>
                        <td class="border px-4 py-2">{{ $Course->course_code }}</td>
                        <td class="border px-4 py-2">{{ $Course->courseType->name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $Course->level->name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $Course->organizer->name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $Course->course_name }}</td>
                        <td class="border px-4 py-2">{{ $Course->certification_number }}</td>
                        <td class="border px-4 py-2">{{ \App\Models\Course::STATUS[$Course->status] ?? '不明' }}</td>
                        <td class="border px-4 py-2">{{ $Course->created_at->format('Y-m-d') }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.courses.show', $Course->id) }}" class="text-green-600">詳細</a>
                            <a href="{{ route('admin.courses.edit', $Course->id) }}" class="text-blue-600 ml-2">編集</a>
>>>>>>> 047295209a8f311d8ebcbed3779e2ddeb40bf00a

                                    {{-- 統一削除モーダル --}}
                                    <div x-data="{ open: false }" x-cloak>
                                        <button @click="open = true" class="text-red-600 hover:text-red-400">削除</button>

                                        <div x-show="open" x-transition.opacity.duration.200ms
                                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                            <div x-show="open" x-transition.scale.duration.200ms
                                                class="bg-white p-6 rounded-lg shadow-md max-w-sm w-full">
                                                <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                                                <p class="text-gray-700 text-center mb-5">
                                                    「{{ $Course->course_name }}」を削除しますか？
                                                </p>
                                                <div class="flex justify-center gap-4">
                                                    <button @click="open = false"
                                                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">キャンセル</button>
                                                    <form action="{{ route('admin.courses.destroy', $Course->id) }}"
                                                        method="POST">
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
                                    </div>
                                    {{-- /削除モーダル --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    @endsection
