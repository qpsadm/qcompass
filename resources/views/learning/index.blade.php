@extends('layouts.app')

@section('content')
    <div x-data="{ open: false, deleteUrl: '', deleteName: '' }" class="container mx-auto p-6">

        <h1 class="text-2xl font-bold mb-4">学習コンテンツ一覧</h1>

        @php
            $typeLabels = [
                'book' => '1. 本',
                'site' => '2. サイト',
                'video' => '3. 動画',
                'article' => '4. 記事',
            ];
            $levelLabels = [1 => '初級', 2 => '中級', 3 => '上級'];
        @endphp

        <a href="{{ route('admin.learnings.create') }}"
            class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-green-600 transition">
            新規作成
        </a>

        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-2 py-1">ID</th>
                        <th class="border px-2 py-1">種類</th>
                        <th class="border px-2 py-1">タイトル</th>
                        <th class="border px-2 py-1">説明</th>
                        <th class="border px-2 py-1">画像</th>
                        <th class="border px-2 py-1">URL</th>
                        <th class="border px-2 py-1">レベル</th>
                        <th class="border px-2 py-1">表示</th>
                        <th class="border px-2 py-1">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($learnings as $learning)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-2 py-1">{{ $learning->id }}</td>
                            <td class="border px-2 py-1">{{ $typeLabels[$learning->type] ?? $learning->type }}</td>
                            <td class="border px-2 py-1">{{ $learning->title }}</td>
                            <td class="border px-2 py-1">{{ $learning->description }}</td>
                            <td class="border px-2 py-1">
                                @if ($learning->image)
                                    <img src="{{ $learning->image }}" class="w-16 h-16 object-cover">
                                @endif
                            </td>
                            <td class="border px-2 py-1">
                                @if ($learning->url)
                                    <a href="{{ $learning->url }}" target="_blank" class="text-blue-600 underline">リンク</a>
                                @else
                                    なし
                                @endif
                            </td>
                            <td class="border px-2 py-1">{{ $levelLabels[$learning->level] ?? '-' }}</td>
                            <td class="border px-2 py-1 text-center">
                                @if ((bool) $learning->is_visible)
                                    <span class="text-green-600 font-bold">✔</span>
                                @else
                                    <span class="text-red-600 font-bold">❌</span>
                                @endif
                            </td>

                            <td class="border px-2 py-1 text-center">
                                <a href="{{ route('admin.learnings.edit', $learning->id) }}"
                                    class="text-blue-600 hover:underline">編集</a>
                                <a href="#"
                                    @click.prevent="open = true; deleteUrl='{{ route('admin.learnings.destroy', $learning->id) }}'; deleteName='{{ $learning->title }}';"
                                    class="text-red-600 hover:underline ml-4">
                                    削除
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="border px-2 py-2 text-center text-gray-500">データがありません</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 削除確認モーダル -->
        <div x-show="open" x-cloak x-transition.opacity.duration.200ms
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div x-show="open" x-transition.scale.duration.200ms
                class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                <p class="text-gray-700 text-center mb-5">
                    「<span x-text="deleteName"></span>」を削除しますか？
                </p>
                <div class="flex justify-center space-x-4">
                    <button @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        キャンセル
                    </button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
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
