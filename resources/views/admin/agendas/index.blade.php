@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{ open: false, deleteUrl: '', deleteName: '' }">
        <h1 class="text-2xl font-bold mb-4">アジェンダ一覧</h1>

        {{-- 上部操作・検索・絞り込み --}}
        <div class="flex items-center justify-between mb-4 space-x-2">

            {{-- 新規作成 --}}
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.agendas.create') }}"
                    class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                    <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
                    <span class="hidden lg:inline ml-1">新規作成</span>
                </a>
            </div>

            {{-- 検索 + カテゴリー + ステータス --}}
            <div class="flex items-center space-x-2 flex-1">

                {{-- 絞り込みフォーム --}}
                <form method="GET" action="{{ route('admin.agendas.index') }}" class="flex items-center space-x-2 flex-1">
                    {{-- カテゴリー --}}
                    <select name="category_id" class="border px-2 py-1 rounded">
                        <option value="">全てのカテゴリー</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- ステータス --}}
                    <select name="status" class="border px-2 py-1 rounded">
                        <option value="">全てのステータス</option>
                        <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>承認済み</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>下書き</option>
                    </select>

                    {{-- 検索 --}}
                    <div x-data="searchBox()" class="relative flex-1">
                        <input type="text" name="search" x-model="search" placeholder="アジェンダ名で検索"
                            @keydown.enter.prevent="submit()" class="w-full border px-2 py-1 rounded pr-8">
                        <button type="button" x-show="search" @click="clear()"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">&times;
                        </button>
                    </div>

                    <button type="button" @click="submit()"
                        class="bg-blue-500 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition">
                        絞り込み
                    </button>
                </form>
            </div>

        </div>

        <script>
            function searchBox() {
                return {
                    search: "{{ request('search') }}",
                    url: "{{ route('admin.agendas.index') }}",
                    submit() {
                        const form = document.createElement('form');
                        form.method = 'GET';
                        form.action = this.url;

                        const inputSearch = document.createElement('input');
                        inputSearch.type = 'hidden';
                        inputSearch.name = 'search';
                        inputSearch.value = this.search;
                        form.appendChild(inputSearch);

                        // category + statusも追加
                        const category = document.querySelector('select[name="category_id"]');
                        if (category) {
                            const inputCat = document.createElement('input');
                            inputCat.type = 'hidden';
                            inputCat.name = 'category_id';
                            inputCat.value = category.value;
                            form.appendChild(inputCat);
                        }

                        const status = document.querySelector('select[name="status"]');
                        if (status) {
                            const inputStatus = document.createElement('input');
                            inputStatus.type = 'hidden';
                            inputStatus.name = 'status';
                            inputStatus.value = status.value;
                            form.appendChild(inputStatus);
                        }

                        document.body.appendChild(form);
                        form.submit();
                    },
                    clear() {
                        this.search = '';
                        this.submit();
                    }
                }
            }
        </script>

        {{-- アジェンダテーブル --}}
        <div class="overflow-x-auto mt-4">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 w-16 text-center">No.</th>
                        <th class="border px-4 py-2 cursor-pointer"
                            @click="window.location='{{ request()->fullUrlWithQuery(['sort' => 'agenda_name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}'">
                            アジェンダ名
                            @if (request('sort') === 'agenda_name')
                                <span>{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th class="border px-4 py-2">カテゴリー</th>
                        <th class="border px-4 py-2 text-center">表示</th>
                        <th class="border px-4 py-2">承認</th>
                        <th class="border px-4 py-2">作成者</th>
                        <th class="border px-4 py-2 text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agendas as $agenda)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">
                                {{ ($agendas->currentPage() - 1) * $agendas->perPage() + $loop->iteration }}
                            </td>
                            <td class="border px-4 py-2">{{ $agenda->agenda_name }}</td>
                            <td class="border px-4 py-2">{{ $agenda->category->category_name ?? '未分類' }}</td>
                            <td class="border px-4 py-2 text-center">
                                @if ($agenda->is_show)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $agenda->status === 'yes' ? '承認済み' : '下書き' }}</td>
                            <td class="border px-4 py-2">{{ $agenda->created_user_name ?? '不明' }}</td>
                            <td class="border px-4 py-2 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    {{-- プレビュー --}}
                                    <button type="button"
                                        class="flex items-center text-green-600 hover:text-green-700 preview-button"
                                        data-content='@json($agenda->content)'
                                        data-title="{{ $agenda->agenda_name }}">
                                        <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-4 h-4">
                                        <span class="hidden lg:inline ml-1">プレビュー</span>
                                    </button>

                                    {{-- 詳細・編集 --}}
                                    <a href="{{ route('admin.agendas.show', $agenda->id) }}"
                                        class="flex items-center text-blue-600 hover:text-blue-700">
                                        <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
                                        <span class="hidden lg:inline ml-1">詳細</span>
                                    </a>
                                    <a href="{{ route('admin.agendas.edit', $agenda->id) }}"
                                        class="flex items-center text-blue-600 hover:text-blue-700">
                                        <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
                                        <span class="hidden lg:inline ml-1">編集</span>
                                    </a>

                                    {{-- 削除 --}}
                                    <button
                                        @click="open=true; deleteUrl='{{ route('admin.agendas.destroy', $agenda->id) }}'; deleteName='{{ $agenda->agenda_name }}';"
                                        class="flex items-center text-red-600 hover:text-red-700">
                                        <img src="{{ asset('assets/images/icon/b_dust.svg') }}" class="w-4 h-4">
                                        <span class="hidden lg:inline ml-1">削除</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">アジェンダはまだ登録されていません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ページネーション --}}
            <div class="mt-4">
                {{ $agendas->appends(request()->query())->links() }}
            </div>
        </div>

        {{-- 削除モーダル --}}
        <div x-show="open" x-cloak x-transition.opacity.duration.200ms
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div x-show="open" x-transition.scale.duration.200ms
                class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                <p class="text-gray-700 text-center mb-5">
                    「<span x-text="deleteName"></span>」を削除しますか？
                </p>
                <div class="flex justify-center space-x-4">
                    <button @click="open=false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
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

    {{-- プレビュー用スクリプト --}}
    <script src="{{ asset('js/previewWindow.js') }}" defer></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
