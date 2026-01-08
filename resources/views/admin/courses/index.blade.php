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
            class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">新規作成</span>
        </a>

        <!-- 検索ボックス -->
        <div x-data="searchBox()" class="flex flex-wrap items-center gap-2 w-full lg:w-auto mt-2 lg:mt-0">
            <!-- 入力欄 -->
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" x-model="search"
                    placeholder="講座コード・講座名で検索"
                    @keydown.enter.prevent="submit()"
                    class="border px-3 py-2 rounded-l-md focus:outline-none focus:ring-1 focus:ring-blue-400 w-full">

                <!-- クリアボタン -->
                <button type="button" x-show="search" @click="clear()"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">&times;
                </button>
            </div>

            <!-- 検索ボタン -->
            <button @click="submit()"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-md flex items-center justify-center space-x-2">
                <img src="{{ asset('assets/images/icon/b_search.svg') }}" class="w-4 h-4">
                <span>検索</span>
            </button>
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
    <div class="my-2">
        {{ $courses->appends(request()->query())->links('pagination::tailwind') }}
    </div>

    <!-- テーブル -->
    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 w-12 text-center">
                        <a href="{{ route('admin.courses.index', array_merge(request()->query(), ['sort'=>'id','order'=>$sort==='id' ? $nextOrder : 'asc'])) }}"
                            class="flex items-center justify-center gap-1 hover:underline">
                            No.
                            @if($sort==='id')
                            <span>{{ $order==='asc'?'▲':'▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th class="border px-4 py-2 w-24">
                        <a href="{{ route('admin.courses.index', array_merge(request()->query(), ['sort'=>'course_code','order'=>$sort==='course_code' ? $nextOrder : 'asc'])) }}"
                            class="flex items-center justify-center gap-1 hover:underline">
                            講座コード
                            @if($sort==='course_code')
                            <span>{{ $order==='asc'?'▲':'▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th class="border px-4 py-2">
                        <a href="{{ route('admin.courses.index', array_merge(request()->query(), ['sort'=>'course_name','order'=>$sort==='course_name' ? $nextOrder : 'asc'])) }}"
                            class="flex items-center gap-1 hover:underline">
                            講座名
                            @if($sort==='course_name')
                            <span>{{ $order==='asc'?'▲':'▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th class="border px-4 py-2">分野</th>
                    <th class="border px-4 py-2 w-32">期間</th>
                    <th class="border px-4 py-2 text-center w-24">表示</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">
                        {{ ($courses->currentPage()-1)*$courses->perPage()+$loop->iteration }}
                    </td>
                    <td class="border px-4 py-2">{{ $course->course_code }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.courses.show',$course->id) }}" class="text-blue-600 hover:underline">
                            {{ $course->course_name }}
                        </a>
                    </td>
                    <td class="border px-4 py-2">{{ $course->courseType->name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $course->start_date }} ～ {{ $course->end_date }}</td>
                    <td class="border px-4 py-2 text-center">
                        @if($course->is_show)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                        @else
                        <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                        @endif
                    </td>
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
        {{ $courses->appends(request()->query())->links('pagination::tailwind') }}
    </div>

</div>
@endsection
