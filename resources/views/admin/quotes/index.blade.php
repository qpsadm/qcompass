@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6" x-data="{
        open: false,
        deleteUrl: '',
        deleteQuote: '',
        search: '{{ request('search') }}',
        sort: '{{ request('sort', 'id') }}',
        direction: '{{ request('direction', 'desc') }}',
        submitForm(url = null) {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = url || '{{ route('admin.quotes.index') }}';
    
            const inputs = {
                search: this.search,
                sort: this.sort,
                direction: this.direction
            };
    
            for (const name in inputs) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = inputs[name] ?? '';
                form.appendChild(input);
            }
    
            document.body.appendChild(form);
            form.submit();
        },
        clearSearch() {
            this.search = '';
            this.submitForm();
        },
        toggleSort(column) {
            if (this.sort === column) {
                this.direction = this.direction === 'asc' ? 'desc' : 'asc';
            } else {
                this.sort = column;
                this.direction = 'asc';
            }
            this.submitForm();
        }
    }">

        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">名言一覧</h1>

            {{-- 新規作成 --}}
            <a href="{{ route('admin.quotes.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">
                新規作成
            </a>

            {{-- 検索 --}}
            <div class="flex items-center mb-4 space-x-2">
                <div class="relative">
                    <input type="text" x-model="search" placeholder="原文・作者で検索" @keydown.enter.prevent="submitForm()"
                        class="border px-2 py-1 rounded pr-8">
                    <button type="button" x-show="search" @click="clearSearch()"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <button @click="submitForm()"
                    class="bg-blue-500 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition">
                    検索
                </button>
            </div>

            {{-- テーブル --}}
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-left text-gray-700">
                            <th class="border-b px-4 py-2 cursor-pointer" @click="toggleSort('id')">
                                ID
                                <span x-show="sort === 'id'">
                                    <span x-show="direction === 'asc'">&#9650;</span>
                                    <span x-show="direction === 'desc'">&#9660;</span>
                                </span>
                            </th>
                            <th class="border-b px-4 py-2 cursor-pointer" @click="toggleSort('quote_full')">
                                原文
                                <span x-show="sort === 'quote_full'">
                                    <span x-show="direction === 'asc'">&#9650;</span>
                                    <span x-show="direction === 'desc'">&#9660;</span>
                                </span>
                            </th>
                            <th class="border-b px-4 py-2 cursor-pointer" @click="toggleSort('author_full')">
                                作者
                                <span x-show="sort === 'author_full'">
                                    <span x-show="direction === 'asc'">&#9650;</span>
                                    <span x-show="direction === 'desc'">&#9660;</span>
                                </span>
                            </th>
                            <th class="border-b px-4 py-2 text-center w-1/4">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($quotes as $quote)
                            <tr class="hover:bg-gray-50">
                                <td class="border-b px-4 py-2">{{ $quote->id }}</td>
                                <td class="border-b px-4 py-2">{{ $quote->quote_full }}</td>
                                <td class="border-b px-4 py-2">{{ $quote->author_full }}</td>
                                <td class="border-b px-4 py-2 text-center flex justify-center gap-2">
                                    <a href="{{ route('admin.quotes.show', $quote->id) }}"
                                        class="text-green-500 hover:underline">詳細</a>
                                    <a href="{{ route('admin.quotes.edit', $quote->id) }}"
                                        class="text-blue-500 hover:underline">編集</a>
                                    <button
                                        @click="open = true; deleteUrl='{{ route('admin.quotes.destroy', $quote->id) }}'; deleteQuote='{{ $quote->quote_full }}';"
                                        class="text-red-500 hover:underline bg-transparent p-0">
                                        削除
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4">データがありません</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- ページネーション --}}
                <div class="mt-4">
                    {{ $quotes->links() }}
                </div>
            </div>

            {{-- 削除モーダル --}}
            <div x-show="open" x-cloak x-transition.opacity.duration.200ms
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div x-transition.scale.duration.200ms class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                    <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                    <p class="text-gray-700 text-center mb-5">
                        「<span x-text="deleteQuote"></span>」を削除しますか？
                    </p>
                    <div class="flex justify-center gap-4">
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

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </div>
@endsection
