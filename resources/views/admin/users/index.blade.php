@php
    $sort = request('sort', 'id');
    $order = request('order', 'asc');
    $nextOrder = $order === 'asc' ? 'desc' : 'asc';
@endphp

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4 text-gray-800">ユーザー一覧</h1>

        <!-- 上部操作バー -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-4 gap-3">

            <!-- 左側: 新規作成 / ゴミ箱 / なりすまし -->
            <div class="flex items-center space-x-2 mb-2 lg:mb-0">
                <!-- なりすましボタン（自分のIDで開始） -->
                {{-- <form action="{{ route('admin.users.impersonate', auth()->id()) }}" method="POST" class="inline-block">
                @csrf
                <button type="submit"
                    class="bg-red-500 text-white border border-purple-800 px-4 py-2 rounded font-medium
               hover:bg-purple-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                    なりすまし
                </button>
            </form> --}}
                <a href="{{ route('admin.users.create') }}"
                    class="new bg-yellow-400 border border-gray-200 px-4 py-2 mr-1 text-black rounded hover:bg-blue-300 hover:text-white transition flex items-center space-x-1">
                    {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                    <span class="hidden lg:inline ml-1">新規作成</span>
                </a>
                <a href="{{ route('admin.users.trash') }}"
                    class="bg-red-100 px-4 py-2 rounded hover:bg-red-600 hover:text-white flex items-center gap-1">
                    ゴミ箱
                </a>
            </div>

            <!-- 右側: 絞り込み + 検索 -->
            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-2">

                <!-- 講座選択 + 未所属 -->
                <form method="GET" action="{{ route('admin.users.index') }}"
                    class="flex items-center space-x-2 mb-2 mr-6 lg:mb-0 justify-between gap-2" style="width: 550px;">
                    <select name="course_id" class="border px-2 py-1 rounded">
                        <option value="">全ての講座</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>

                    <label class="flex items-center space-x-1">
                        <input type="checkbox" name="unassigned" value="1"
                            {{ request('unassigned') == '1' ? 'checked' : '' }}>
                        <span>未所属</span>
                    </label>

                    <button class="text-white bg-emerald-600 px-3 py-2 rounded hover:bg-red-600">絞り込み</button>
                </form>

                <!-- 検索フォーム -->
                <div x-data="searchBox()" class="flex items-center space-x-2">
                    <form :action="url" method="GET" class="relative flex-1">
                        <input type="text" name="search" x-model="search" placeholder="ユーザー名・コード・電話番号で検索"
                            @keydown.enter.prevent="submit()" class="w-full border px-2 py-1 rounded pr-8">
                        <button type="button" x-show="search" @click="clear()"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">&times;
                        </button>
                    </form>
                    <button @click="submit()"
                        class="bg-blue-600 px-4 py-2 rounded hover:bg-opacity-50 text-white">検索</button>
                </div>

            </div>

            <script>
                function searchBox() {
                    return {
                        search: "{{ request('search') }}",
                        url: "{{ route('admin.users.index') }}",
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

        <!-- ページネーション（上） -->
        {{-- <div class="my-2">
            {{ $users->appends(request()->query())->links() }}
        </div> --}}

        <!-- ユーザーテーブル -->
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 w-12" style="background-color: #2563eb;">
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'id', 'order' => $sort === 'id' ? $nextOrder : 'asc'])) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                No.
                                @if ($sort === 'id')
                                    <span>{{ $order === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-24" style="background-color: #2563eb;">
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'code', 'order' => $sort === 'code' ? $nextOrder : 'asc'])) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                ユーザーコード
                                @if ($sort === 'code')
                                    <span>{{ $order === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-32">氏名</th>
                        <th class="border px-4 py-2 w-40">所属講座</th>
                        <th class="border px-4 py-2 w-24">電話番号</th>
                        <th class="border px-4 py-2 w-24">権限</th>
                        <th class="border px-4 py-2 w-16">状態</th>
                        <th class="border px-4 py-2 w-16">表示</th>
                        <th class="border px-4 py-2 w-24">作成日</th>
                        <th class="border px-4 py-2 w-24" style="background-color: #2563eb;">
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'updated_at', 'order' => $sort === 'updated_at' ? $nextOrder : 'asc'])) }}"
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
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>
                            <td class="border px-4 py-2">{{ $user->code }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:underline">
                                    {{ $user->name }} ({{ $user->id }})
                                </a>
                            </td>
                            <td class="border px-4 py-2">
                                @if ($user->courses && $user->courses->count() > 0)
                                    {{ $user->courses->pluck('course_name')->join(', ') }}
                                @else
                                    未所属
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $user->detail->phone1 ?? 'なし' }}</td>
                            <td class="border px-4 py-2">{{ $user->role->role_name ?? 'なし' }}</td>
                            <td class="border px-4 py-2 text-center">{{ $user->detail?->status_label }}</td>
                            <td class="border px-4 py-2 text-center">
                                @if ($course->is_show)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                                @endif
                            </td>
                            {{-- ->format('Y-m-d H:i') --}}
                            <td class="border px-4 py-2 text-center">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                            <td class="border px-4 py-2 text-center">{{ $user->updated_at->format('Y-m-d H:i') }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border px-4 py-2 text-center text-gray-500">データがありません</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ページネーション（下） -->
        <div class="mt-4">
            {{ $users->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
