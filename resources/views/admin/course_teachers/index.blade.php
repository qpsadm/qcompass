@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4 text-gray-800">講座・講師一覧</h1>
        <!-- 上部操作バー -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between">

            <!-- 左側: 新規作成 / ゴミ箱 / なりすまし -->
            <div class="flex items-center space-x-2 mb-2 lg:mb-0">

                <!-- 新規作成ボタン -->
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('admin.course_teachers.create') }}"
                        class="new bg-yellow-400 border border-gray-200 px-4 py-2 text-black rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                        {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                        <span class="hidden lg:inline ml-1">新規作成</span>
                    </a>
                </div>
            </div>

            <!-- 右側: 絞り込み + 検索 -->
            <div class="flex flex-col lg:flex-row items-end lg:items-center gap-4">

                <!-- 講座選択 + 未所属 -->
                <form method="GET" action="{{ route('admin.course_teachers.index') }}"
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
                        class="bg-blue-600 px-4 py-2 rounded hover:bg-opacity-50 text-white">検索</button>
                </div>
            </div>
            <script>
                function searchBox() {
                    return {
                        search: "{{ request('search') }}",
                        url: "{{ route('admin.course_teachers.index') }}",
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
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="sort-cl border px-4 py-2 text-center w-20">
                            {{-- No. --}}
                            <a href="{{ route('admin.course_teachers.index', [
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
                        <th class="sort-cl border px-4 py-2">
                            {{-- 講座名 --}}
                            <a href="{{ route('admin.course_teachers.index', [
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
                        <th class="border px-4 py-2">講師名</th>
                        <th class="border px-4 py-2">担当区分</th>
                        <th class="sort-cl border px-4 py-2 w-40">
                            {{-- 更新日時 --}}
                            <a href="{{ route('admin.course_teachers.index', [
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
                <tbody>
                    @forelse($course_teachers as $teacher)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">
                                {{ ($course_teachers->currentPage() - 1) * $course_teachers->perPage() + $loop->iteration }}
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.course_teachers.edit', $teacher->id) }}"
                                    class="text-blue-600 hover:text-blue-800 hover:underline transition">
                                    {{ $teacher->course?->course_name ?? '-' }}
                                </a>
                            </td>
                            <td class="border px-4 py-2">{{ $teacher->user?->name ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $teacher->role_name ?? '-' }}</td>
                            <td class="border px-4 py-2 text-center">
                                {{ $teacher->updated_at->format('Y/m/d H:i') }}</td>
                            <td class="border px-4 py-2 text-center">{{ $teacher->updated_user_name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ページネーション -->
        <div class="mt-4">
            {{ $course_teachers->links() }}
        </div>

    </div>
@endsection
