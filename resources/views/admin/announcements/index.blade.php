@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{
        open: false,
        deleteUrl: '',
        deleteName: '',
        search: '{{ request('search') }}',
        category: '{{ request('category_id') }}',
        status: '{{ request('status') }}',
        sort: '{{ request('sort', 'title') }}',
        direction: '{{ request('direction', 'desc') }}',
        submitForm(url = null) {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = url || '{{ route('admin.announcements.index') }}';
    
            const inputs = {
                search: this.search,
                category_id: this.category,
                status: this.status,
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

        <h1 class="text-2xl font-bold mb-4">お知らせ一覧</h1>

        {{-- 上部操作 + 検索 + 絞り込み --}}
        <div class="flex flex-wrap items-center justify-between mb-4 space-y-2">
            <a href="{{ route('admin.announcements.create') }}"
                class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <span>新規作成</span>
            </a>

            <div class="flex items-center space-x-2">
                {{-- 検索 --}}
                <div class="relative">
                    <input type="text" x-model="search" placeholder="タイトルで検索" @keydown.enter.prevent="submitForm()"
                        class="border px-2 py-1 rounded pr-8">
                    <button type="button" x-show="search" @click="clearSearch()"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <button @click="submitForm()"
                    class="bg-blue-500 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition">
                    検索
                </button>

                {{-- カテゴリー --}}
                <select x-model="category" @change="submitForm()" class="border px-2 py-1 rounded">
                    <option value="">すべてのカテゴリー</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->type_name }}</option>
                    @endforeach
                </select>

                {{-- ステータス --}}
                <select x-model="status" @change="submitForm()" class="border px-2 py-1 rounded">
                    <option value="">すべての状態</option>
                    <option value="0">下書き</option>
                    <option value="1">承認待ち</option>
                    <option value="2">承認済み</option>
                </select>
            </div>
        </div>

        {{-- テーブル --}}
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-center w-16">No.</th>
                        <th class="border px-4 py-2 cursor-pointer" @click="toggleSort('title')">
                            タイトル
                            <span x-show="sort === 'title'">
                                <span x-show="direction === 'asc'">&#9650;</span>
                                <span x-show="direction === 'desc'">&#9660;</span>
                            </span>
                        </th>
                        <th class="border px-4 py-2">カテゴリー</th>
                        <th class="border px-4 py-2 text-center w-32">表示</th>
                        <th class="border px-4 py-2 text-center w-32">状態</th>
                        <th class="border px-4 py-2 text-center w-40">作成者</th>
                        <th class="border px-4 py-2 text-center w-60">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($announcements as $announcement)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">
                                {{ ($announcements->currentPage() - 1) * $announcements->perPage() + $loop->iteration }}
                            </td>
                            <td class="border px-4 py-2">{{ $announcement->title }}</td>
                            <td class="border px-4 py-2">{{ $announcement->type->type_name ?? '-' }}</td>
                            <td class="border px-4 py-2 text-center">
                                <span class="px-2 py-1 rounded-full text-xs"
                                    :class="announcement.is_show ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700'">
                                    {{ $announcement->is_show ? '表示' : '非表示' }}
                                </span>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                @if ($announcement->status == 0)
                                    下書き
                                @elseif($announcement->status == 1)
                                    承認待ち
                                @else
                                    承認済み
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center">{{ $announcement->created_user_name ?? '不明' }}</td>
                            <td class="border px-4 py-2 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.announcements.show', $announcement->id) }}"
                                        class="text-green-600 flex items-center">詳細</a>
                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                                        class="text-blue-600 hover:text-blue-700 flex items-center">編集</a>
                                    <button
                                        @click="open = true; deleteUrl='{{ route('admin.announcements.destroy', $announcement->id) }}'; deleteName='{{ $announcement->title }}';"
                                        class="text-red-600 hover:text-red-700 flex items-center">削除</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">お知らせはまだ登録されていません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ページネーション --}}
            <div class="mt-4">
                {{ $announcements->links() }}
            </div>
        </div>

        {{-- 削除モーダル --}}
        <div x-show="open" x-cloak x-transition.opacity.duration.200ms
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full" x-transition.scale.duration.200ms>
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

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
