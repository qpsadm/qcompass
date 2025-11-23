@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md"
    x-data="{ open: false, deleteUrl: '', deleteTitle: '' }">

    <h1 class="text-2xl font-bold mb-4">日報一覧</h1>

    <div class="flex items-center justify-between mb-4">

        <!-- 左：新規作成  -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.reports.create') }}"
                class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>
        </div>

        <!-- 右：検索 -->
        <div x-data="searchBox()" class="flex items-center space-x-2">
            <form :action="url" method="GET" class="relative flex-1">
                <input
                    type="text"
                    name="search"
                    x-model="search"
                    placeholder="タイトル・提出者で検索"
                    @keydown.enter.prevent="submit()"
                    class="w-full border px-2 py-1 rounded pr-8">

                <!-- ×ボタン -->
                <button
                    type="button"
                    x-show="search"
                    @click="clear()"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </form>
            <button @click="submit()"
                class="bg-blue-500 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_search.svg') }}" class="w-4 h-4">
                <span class="hidden lg:inline ml-1">検索</span>
            </button>
        </div>

        <script>
            function searchBox() {
                return {
                    search: "{{ request('search') }}",
                    url: "{{ route('admin.reports.index') }}",
                    submit() {
                        const form = document.createElement('form');
                        form.method = 'GET';
                        form.action = this.url;
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'search';
                        input.value = this.search;
                        form.appendChild(input);
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

    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">提出者</th>
                    <th class="border px-4 py-2">講座</th>
                    <th class="border px-4 py-2">日付</th>
                    <th class="border px-4 py-2">タイトル</th>
                    <th class="border px-4 py-2 text-center w-60">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                <tr>
                    <td class="border px-4 py-2">{{ $report->user->name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $report->course->course_name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $report->date }}</td>
                    <td class="border px-4 py-2">{{ $report->title }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex items-center justify-center flex-nowrap space-x-2">

                            <!-- 詳細 -->
                            <a href="{{ route('admin.reports.show', $report->id) }}"
                                class="flex items-center text-green-600 hover:text-green-700">
                                <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">詳細</span>
                            </a>

                            <!-- 削除 -->
                            <button @click="open = true; deleteUrl='{{ route('admin.reports.destroy', $report->id) }}'; deleteTitle='{{ $report->title }}';"
                                class="flex items-center text-red-600 hover:text-red-700">
                                <img src="{{ asset('assets/images/icon/b_dust.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">削除</span>
                            </button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- ページネーション -->
        <div class="mt-4">
            {{ $reports->appends(request()->query())->links() }}
        </div>
    </div>

    {{-- ✅ 共通削除モーダル --}}
    <div x-show="open" x-cloak x-transition.opacity.duration.200ms
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div x-show="open" x-transition.scale.duration.200ms
            class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
            <p class="text-gray-700 text-center mb-5">
                「<span x-text="deleteTitle"></span>」を削除しますか？
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
    {{-- /共通削除モーダル --}}

</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection
