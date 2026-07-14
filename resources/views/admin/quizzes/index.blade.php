@php
    $sort = request('sort', 'id');
    $order = request('order', 'asc');
    $nextOrder = $order === 'asc' ? 'desc' : 'asc';
@endphp

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4">クイズ一覧</h1>

        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-4 gap-3">

            <!-- 左側: 新規作成 / ゴミ箱 / なりすまし -->
            <div class="flex items-center space-x-2 mb-2 lg:mb-0">
                {{-- <div class="flex justify-between mb-4"> --}}
                <a href="{{ route('admin.quizzes.create') }}"
                    class="bg-yellow-400 border border-gray-200 px-4 py-2 text-black rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                    {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                    <span class="hidden lg:inline ml-1">新規作成</span>
                </a>
            </div>

            <!-- 右側: 絞り込み + 検索 -->
            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-2">
                <form method="GET" action="{{ route('admin.quizzes.index') }}"
                    class="flex items-center space-x-2 mb-2 mr-6 lg:mb-0">
                    <select name="category_id" class="border px-2 py-1 rounded">
                        <option value="">全てのカテゴリ</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <button class="text-white bg-emerald-600 px-3 py-2 rounded hover:bg-gray-300">絞り込み</button>
                </form>

                <div x-data="searchBox()" class="flex items-center space-x-2">
                    <form :action="url" method="GET" class="relative flex-1">
                        <input type="text" name="search" x-model="search" placeholder="タイトルで検索"
                            @keydown.enter.prevent="submit()" class="w-full border px-2 py-1 rounded pr-8">

                        <button type="button" x-show="search" @click="clear()"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">&times;
                        </button>

                    </form>
                    <button @click="submit()" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 text-white">検索</button>

                    <script>
                        function searchBox() {
                            return {
                                search: "{{ request('search') }}",
                                url: "{{ route('admin.quizzes.index') }}",
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
            </div>
        </div>

        <!-- ページネーション（上） -->
        {{-- {{ $quizzes->links() }} --}}

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <!-- ID ソート -->
                        <th class="border px-4 py-2 w-12" style="background-color: #2563eb;">
                            <a href="{{ route('admin.quizzes.index', [
                                'sort' => 'id',
                                'direction' => $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                ID
                                @if ($sort === 'id')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>

                        <!-- タイトル ソート -->
                        <th class="border px-4 py-2 w-48">クイズタイトル</th>
                        <th class="border px-4 py-2 w-32">カテゴリ(科目名)</th>
                        <th class="border px-4 py-2 w-20">レベル</th>
                        <th class="border px-4 py-2 w-20 text-center">問題数</th>
                        <th class="border px-4 py-2 w-24 text-center">表示</th>
                        <th class="border px-4 py-2 w-24 text-center">作成日</th>
                        <th class="border px-4 py-2 w-24 text-center" style="background-color: #2563eb;">
                            <a href="{{ route('admin.quizzes.index', [
                                'sort' => 'updated_at',
                                'direction' => $sort === 'updated_at' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                更新日
                                @if ($sort === 'updated_at')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>

                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($quizzes as $quiz)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">
                                {{ $quiz->id }}
                            </td>

                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.quizzes.show', $quiz->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $quiz->title }}
                                </a>
                            </td>

                            <td class="border px-4 py-2">
                                {{ $quiz->category?->name ?? '-' }}
                            </td>

                            <td class="border px-4 py-2 text-center">
                                {{ $quiz->level ?? '-' }}
                            </td>

                            <td class="border px-4 py-2 text-center">
                                {{ $quiz->questions_count }}
                            </td>

                            <td class="border px-4 py-2 text-center">
                                @if ($quiz->is_show)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                        公開
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">
                                        非公開
                                    </span>
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center">{{ $quiz->created_at->format('Y-m-d H:i') }}</td>
                            <td class="border px-4 py-2 text-center">{{ $quiz->updated_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ページネーション（下） -->
        <div class="mt-4">
            {{ $quizzes->appends(request()->query())->links() }}
            {{-- {{ $quizzes->links() }} --}}
        </div>

    </div>
@endsection
