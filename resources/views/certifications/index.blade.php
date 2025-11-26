@extends('layouts.app')

@section('content')
    <div x-data="{ open: false, deleteUrl: '', deleteName: '' }" class="container mx-auto p-6">

        {{-- 🌟 白いカード枠で囲む --}}
        <div class="bg-white rounded-lg shadow-md p-6">

            <h1 class="text-2xl font-bold mb-4">資格一覧</h1>

            @php
                $levelLabels = [
                    1 => '初級',
                    2 => '上級',
                ];
            @endphp

            <a href="{{ route('admin.certifications.create') }}"
                class="bg-blue-500  px-4 py-2 rounded  hover:bg-blue-600 hover:text-white transition inline-flex justify-center max-w-xs mb-4">
                新規作成
            </a>

            {{-- 🌟 テーブル --}}
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-2 py-1">ID</th>
                            <th class="border px-2 py-1">資格名</th>
                            <th class="border px-2 py-1">資格レベル</th>
                            <th class="border px-2 py-1">説明・備考</th>
                            <th class="border px-2 py-1">参照URL</th>
                            <th class="border px-2 py-1">表示</th>
                            <th class="border px-2 py-1">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($certifications as $certification)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-2 py-1">{{ $certification->id }}</td>
                                <td class="border px-2 py-1">{{ $certification->name }}</td>
                                <td class="border px-2 py-1">
                                    {{ $levelLabels[$certification->level] ?? $certification->level }}</td>
                                <td class="border px-2 py-1">{{ $certification->description }}</td>
                                <td class="border px-2 py-1">
                                    @if ($certification->url)
                                        <a href="{{ $certification->url }}" target="_blank"
                                            class="text-blue-600 underline">リンク</a>
                                    @else
                                        なし
                                    @endif
                                </td>
                                <td class="border px-2 py-1 text-center">
                                    @if ((bool) $certification->is_show)
                                        <span class="text-green-600 font-bold">✔</span>
                                    @else
                                        <span class="text-red-600 font-bold">❌</span>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 text-center">
                                    <a href="{{ route('admin.certifications.edit', $certification->id) }}"
                                        class="text-blue-600 hover:underline">
                                        編集
                                    </a>
                                    <a href="#"
                                        @click.prevent="open = true; deleteUrl='{{ route('admin.certifications.destroy', $certification->id) }}'; deleteName='{{ $certification->name }}';"
                                        class="text-red-600 hover:underline ml-4">
                                        削除
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border px-2 py-2 text-center text-gray-500">データがありません</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- 🌟 ここまでカード枠内 --}}

        </div>
        {{-- 🌟 ここまで白枠 --}}

        <!-- 🗑 モーダル -->
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

    </div>
@endsection
