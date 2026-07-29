@php
    $sort = request('sort', 'id');
    $order = request('order', 'asc');
    $nextOrder = $order === 'asc' ? 'desc' : 'asc';
@endphp

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4 text-gray-800">講座一覧</h1>

        <!-- 上部操作バー -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-4 gap-3">

            <!-- 新規作成ボタン -->
            <a href="{{ route('admin.courses.create') }}"
                class="new g-yellow-400 border border-gray-200 px-4 py-2 text-black rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>

            <!-- 検索ボックス -->
            <div x-data="searchBox()" class="flex flex-wrap items-center gap-2 w-full lg:w-auto mt-2 lg:mt-0">

                <form method="GET" action="{{ route('admin.courses.index') }}"
                    class="flex items-center space-x-2 mb-2 mr-6 lg:mb-0 justify-between gap-2" style="width: 460px;">
                    {{-- 委託者 --}}
                    <select name="organizer_id" class="border px-2 py-1 rounded">
                        <option value="">全ての委託者</option>
                        @foreach ($organizers as $organizer)
                            <option value="{{ $organizer->id }}"
                                {{ request('organizer_id') == $organizer->id ? 'selected' : '' }}>
                                {{ $organizer->name }}
                            </option>
                        @endforeach
                    </select>

                    <button class="text-white bg-emerald-600 px-3 py-2 rounded hover:bg-red-600">絞り込み</button>
                </form>

                <!-- 入力欄 -->
                <div x-data="searchBox()" class="flex items-center space-x-2">
                    <form :action="url" method="GET" class="relative flex-1">
                        <input type="text" name="search" x-model="search" placeholder="講座名・コードで検索"
                            @keydown.enter.prevent="submit()" class="w-full border px-2 py-1 rounded pr-8">
                        <button type="button" x-show="search" @click="clear()"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">&times;
                        </button>
                    </form>
                    <button @click="submit()"
                        class="bg-blue-600 px-4 py-2 rounded hover:bg-opacity-50 text-white">検索</button>
                </div>
            </div>
        </div>

        <script>
            function searchBox() {
                return {
                    search: "{{ request('search') }}",
                    submit() {
                        const form = document.createElement('form');
                        form.method = 'GET';
                        form.action = "{{ route('admin.courses.index') }}";

                        // 検索ワード
                        const inputSearch = document.createElement('input');
                        inputSearch.type = 'hidden';
                        inputSearch.name = 'search';
                        inputSearch.value = this.search;
                        form.appendChild(inputSearch);

                        // 現在のクエリパラメータを保持（ソート・ページ）
                        const urlParams = new URLSearchParams(window.location.search);
                        ['sort', 'order', 'page'].forEach(param => {
                            if (urlParams.has(param)) {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = param;
                                input.value = urlParams.get(param);
                                form.appendChild(input);
                            }
                        });

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

        <!-- ページネーション（上） -->
        {{-- <div class="my-2">
            {{ $courses->appends(request()->query())->links() }}
        </div> --}}

        <!-- テーブル -->
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2 w-12 text-center" style="background-color: #2563eb;">
                            <a href="{{ route('admin.courses.index', array_merge(request()->query(), ['sort' => 'id', 'order' => $sort === 'id' ? $nextOrder : 'asc'])) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                No.
                                @if ($sort === 'id')
                                    <span>{{ $order === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-24" style="background-color: #2563eb;">
                            <a href="{{ route('admin.courses.index', array_merge(request()->query(), ['sort' => 'course_code', 'order' => $sort === 'course_code' ? $nextOrder : 'asc'])) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                講座コード
                                @if ($sort === 'course_code')
                                    <span>{{ $order === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-48">講座名</th>
                        {{-- <th class="border px-4 py-2 w-32">分野</th> --}}
                        <th class="border px-4 py-2 w-40">訓練期間</th>
                        <th class="border px-4 py-2 w-24">受講生人数</th>
                        <th class="border px-4 py-2 w-20">受講生一覧</th>
                        <th class="border px-4 py-2 w-20">表示</th>
                        <th class="border px-4 py-2 w-24">作成日</th>
                        <th class="border px-4 py-2 w-24" style="background-color: #2563eb;">
                            <a href="{{ route('admin.courses.index', array_merge(request()->query(), ['sort' => 'updated_at', 'order' => $sort === 'updated_at' ? $nextOrder : 'asc'])) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                更新日
                                @if ($sort === 'updated_at')
                                    <span>{{ $order === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">
                                {{ ($courses->currentPage() - 1) * $courses->perPage() + $loop->iteration }}
                            </td>
                            <td class="border px-4 py-2">{{ $course->course_code }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.courses.show', $course->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $course->course_name }}&nbsp;({{ $course->id }})<br>
                                    {{ $course->certification_number }}
                                </a>
                            </td>
                            {{-- <td class="border px-4 py-2">{{ $course->courseType->name ?? '-' }}</td> --}}
                            <td class="border px-4 py-2 text-center">{{ $course->start_date }} ～ {{ $course->end_date }}
                            </td>
                            <td class="border px-4 py-2 text-center">入校：{{ $course->entering }}人
                                <br>修了：{{ $course->completed }}人
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('admin.courses.students', $course->id) }}"
                                    class="inline-flex items-center justify-center
              w-9 h-9
              rounded-full
              bg-indigo-500
              text-white
              shadow
              hover:bg-indigo-600
              hover:shadow-md
              transition"
                                    title="受講生一覧">
                                    <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
                                </a>
                            </td>

                            <td class="border px-4 py-2 text-center">
                                @if ($course->is_show)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center">{{ $course->created_at->format('Y-m-d H:i') }}</td>
                            <td class="border px-4 py-2 text-center">{{ $course->updated_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border px-4 py-2 text-center text-gray-500">データがありません</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ページネーション（下） -->
        <div class="mt-4">
            {{ $courses->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
