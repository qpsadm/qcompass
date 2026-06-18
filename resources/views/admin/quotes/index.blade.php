@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{
        search: '{{ request('search') }}',
        sort: '{{ request('sort', 'id') }}',
        direction: '{{ request('direction', 'desc') }}',
        submitForm(url = null) {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = url || '{{ route('admin.quotes.index') }}';
    
            const inputs = { search: this.search, sort: this.sort, direction: this.direction };
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

        <h1 class="text-2xl font-bold mb-4 text-gray-800">名言一覧</h1>

        {{-- 新規作成 --}}
        <div class="flex justify-between mb-4">
            <a href="{{ route('admin.quotes.create') }}"
                class="bg-blue-500 px-4 py-2 text-white rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>
        </div>

        {{-- 検索 --}}
        <div class="flex items-center mb-4 gap-2">
            <input type="text" x-model="search" placeholder="原文・作者で検索" @keydown.enter.prevent="submitForm()"
                class="border px-3 py-2 rounded w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button @click="submitForm()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                検索
            </button>
            <button x-show="search" @click="clearSearch()" class="text-gray-500 hover:text-gray-700 px-2 py-1">クリア</button>
        </div>

        {{-- ページネーション（上） --}}
        <div class="mb-4">
            {{ $quotes->links() }}
        </div>

        {{-- テーブル --}}
        <div class="overflow-x-auto">
            <table class="table-auto w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-2 text-center w-20 cursor-pointer" @click="toggleSort('id')">
                            ID
                            <span x-show="sort==='id'">
                                <span x-show="direction==='asc'">&#9650;</span>
                                <span x-show="direction==='desc'">&#9660;</span>
                            </span>
                        </th>
                        <th class="border px-4 py-2 cursor-pointer" @click="toggleSort('quote_full')">
                            原文
                            <span x-show="sort==='quote_full'">
                                <span x-show="direction==='asc'">&#9650;</span>
                                <span x-show="direction==='desc'">&#9660;</span>
                            </span>
                        </th>
                        <th class="border px-4 py-2 cursor-pointer" @click="toggleSort('author_full')">
                            作者
                            <span x-show="sort==='author_full'">
                                <span x-show="direction==='asc'">&#9650;</span>
                                <span x-show="direction==='desc'">&#9660;</span>
                            </span>
                        </th>
                        <th class="border px-4 py-2 w-60 cursor-pointer" @click="toggleSort('updated_at')">
                            更新日時
                            <span x-show="sort==='updated_at'">
                                <span x-show="direction==='asc'">&#9650;</span>
                                <span x-show="direction==='desc'">&#9660;</span>
                            </span>
                        </th>

                        <th class="border px-4 py-2">表示</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($quotes as $quote)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">{{ $quote->id }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.quotes.edit', $quote->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $quote->quote_full }}
                                </a>
                            </td>
                            <td class="border px-4 py-2">{{ $quote->author_full }}</td>

                            <td class="border px-4 py-2 text-center">{{ $quote->updated_at }}</td>

                            <td class="border px-4 py-2 text-center">
                                @if ($quote->is_show)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                        表示
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">
                                        非表示
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-4">データがありません</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ページネーション（下） --}}
        <div class="mt-4">
            {{ $quotes->links() }}
        </div>

    </div>
@endsection
