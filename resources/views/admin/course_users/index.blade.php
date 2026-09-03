@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4 text-gray-800">講座・受講者一覧</h1>

        <!-- 新規作成・検索 -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between">

            <!-- 左側: 新規作成 / ゴミ箱 / なりすまし -->
            <div class="flex items-center space-x-2 mb-2 lg:mb-0">

                <!-- 新規作成ボタン -->
                <div class="flex items-center justify-between mb-4">

                    <a href="{{ route('admin.course_users.create') }}"
                        class="new bg-yellow-400 border border-gray-200 px-4 py-2 text-black rounded hover:bg-blue-600 flex items-center space-x-1">
                        {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                        <span class="hidden lg:inline ml-1">新規作成</span>
                    </a>
                </div>
            </div>
            <!-- 右側: 絞り込み + 検索 -->
            <div class="flex flex-col lg:flex-row items-end lg:items-center gap-4 mb-4">

                <!-- 講座選択 + 未所属 -->
                <form method="GET" action="{{ route('admin.course_users.index') }}"
                    class="flex items-center space-x-2 mb-2 lg:mb-0 justify-end gap-2" style="width: 550px;">
                    <select name="course_id" class="border px-2 py-1 rounded">
                        <option value="">全ての講座</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="text-white bg-emerald-600 px-3 py-2 rounded hover:bg-red-600">絞り込み</button>
                </form>

                <!-- 検索フォーム -->
                <div x-data="searchBox()" class="flex items-center space-x-2">
                    <form :action="url" method="GET" class="relative flex-1">
                        <input type="text" name="search" x-model="search" placeholder="ユーザー名・講座名で検索"
                            @keydown.enter.prevent="submit()" class="w-full border px-2 py-1 rounded pr-8">
                        <button type="button" x-show="search" @click="clear()"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">&times;
                        </button>
                    </form>
                    <button @click="submit()"
                        class="save bg-blue-600 px-4 py-2 rounded hover:bg-opacity-50 text-white">検索</button>
                </div>
            </div>
            <script>
                function searchBox() {
                    return {
                        search: "{{ request('search') }}",
                        url: "{{ route('admin.course_users.index') }}",
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
        {{-- <div class="mb-3">
        {{ $courseUsers->links() }}
    </div> --}}


        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="sort-cl border px-4 py-2 w-20 text-center">
                            {{-- No. --}}
                            <a href="{{ route('admin.course_users.index', [
                                'sort' => 'id',
                                'direction' => $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                No.
                                @if ($sort === 'id')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="sort-cl border px-4 py-2 w-60">
                            {{-- 講座名 --}}
                            <a href="{{ route('admin.course_users.index', [
                                'sort' => 'course_id',
                                'direction' => $sort === 'course_id' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                講座名
                                @if ($sort === 'course_id')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-40">ユーザー名</th>
                        <th class="border px-4 py-2 w-32">所属部署</th>
                        <th class="border px-4 py-2 w-20">ユーザー権限</th>

                        <th class="border px-4 py-2 w-20">ユーザー表示</th>

                        <th class="sort-cl border px-4 py-2 w-40">
                            {{-- 更新日時 --}}
                            <a href="{{ route('admin.course_users.index', [
                                'sort' => 'updated_at',
                                'direction' => $sort === 'updated_at' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                更新日時
                                @if ($sort === 'updated_at')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-32">更新者名</th>

                    </tr>
                </thead>

                {{-- @php
                    print_r($courseUsers);
                @endphp --}}

                <tbody>
                    @forelse ($courseUsers as $courseUser)
                        <tr class="hover:bg-gray-50">

                            <!-- No. -->
                            <td class="border px-4 py-2 text-center">
                                {{ ($courseUsers->currentPage() - 1) * $courseUsers->perPage() + $loop->iteration }}
                            </td>

                            <!-- 講座名 -->
                            <td class="border px-4 py-2">
                                @if ($courseUser->course)
                                    {{ $courseUser->course->course_name }}
                                @else
                                    <span class="text-gray-400 italic">
                                        削除済み講座
                                    </span>
                                @endif
                            </td>

                            <!-- ユーザー名 -->
                            <td class="border px-4 py-2">
                                @if ($courseUser->user)
                                    <a href="{{ route('admin.course_users.edit', $courseUser->id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $courseUser->user->name }}
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">
                                        削除済みユーザー
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $courseUser->user->division->name ?? '未定' }}
                            </td>

                            <td>
                                {{ $courseUser->user->role->role_name ?? '権限なし' }}
                            </td>


                            <td class="border px-2 py-2 text-center">
                                @if ($courseUser->user->is_show)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center">
                                {{ $courseUser->updated_at->format('Y/m/d H:i') }}</td>
                            <td class="border px-4 py-2 text-center">
                                {{ $courseUser->updated_user_name }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border px-4 py-6 text-center text-gray-500">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ページネーション（下） -->
        <div class="mt-4">
            {{ $courseUsers->links() }}
        </div>

    </div>
@endsection
