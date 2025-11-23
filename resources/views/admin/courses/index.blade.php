@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 pb-24 max-w-6xl" x-data="{ open: false, deleteUrl: '', deleteName: '' }">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">講座一覧</h1>

        {{-- 上部操作 --}}
        <div class="flex justify-between mb-4">
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.courses.create') }}"
                    class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                    <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
                    <span class="hidden lg:inline ml-1">新規作成</span>
                </a>
            </div>

            <div x-data="searchBox()" class="flex items-center space-x-2">
                <form :action="url" method="GET" class="relative flex-1">
                    <input type="text" name="search" x-model="search" placeholder="講座コード・講座名で検索"
                        @keydown.enter.prevent="submit()"
                        class="w-full border px-2 py-1 rounded pr-8">
                    <button type="button" x-show="search" @click="clear()"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">&times;</button>
                </form>
                <button @click="submit()"
                    class="bg-blue-500 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                    <img src="{{ asset('assets/images/icon/b_search.svg') }}" class="w-4 h-4">
                    <span class="hidden lg:inline ml-1">検索</span>
                </button>
            </div>
        </div>

        <script>
            function searchBox() {
                return {
                    search: "{{ request('search') }}",
                    url: "{{ route('admin.courses.index') }}",
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

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 w-32">講座コード</th>
                        <th class="border px-4 py-2">講座名</th>
                        <th class="border px-4 py-2">分野</th>
                        <th class="border px-4 py-2">期間</th>
                        <th class="border px-4 py-2">状態</th>
                        <th class="border px-4 py-2">表示</th>
                        <th class="border px-4 py-2 w-60 text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr>
                        <td class="border px-4 py-2">{{ $course->course_code }}</td>
                        <td class="border px-4 py-2">{{ $course->course_name }}</td>
                        <td class="border px-4 py-2">{{ $course->courseType->name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $course->start_date }} ～ {{ $course->end_date }}</td>
                        <td class="border px-4 py-2">
                            @if($course->status == 'draft')
                            📝 下書き
                            @elseif($course->status == 'open')
                            ✅ 公開
                            @else
                            🔒 閉講
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-center">
                            @if($course->is_show)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                            @else
                            <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                            @endif
                        </td>

                        <td class="border px-4 py-2 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.courses.show', $course->id) }}"
                                    class="text-green-600 hover:text-green-700 flex items-center space-x-1">
                                    <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-4 h-4">
                                    <span class="hidden lg:inline ml-1">詳細</span>
                                </a>
                                <a href="{{ route('admin.courses.edit', $course->id) }}"
                                    class="text-blue-600 hover:text-blue-700 flex items-center space-x-1">
                                    <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
                                    <span class="hidden lg:inline ml-1">編集</span>
                                </a>
                                <button @click="open = true; deleteUrl='{{ route('admin.courses.destroy', $course->id) }}'; deleteName='{{ $course->course_name }}';"
                                    class="text-red-600 hover:text-red-700 flex items-center space-x-1">
                                    <img src="{{ asset('assets/images/icon/b_dust.svg') }}" class="w-4 h-4">
                                    <span class="hidden lg:inline ml-1">削除</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">データがありません</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $courses->appends(request()->query())->links() }}
            </div>
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
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection
