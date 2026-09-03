@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4">質疑応答一覧</h1>

        <!-- 新規作成・検索 -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between">

            <!-- 左側: 新規作成 -->
            <div class="flex items-center space-x-2 mb-2 lg:mb-0">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('admin.questions.create') }}"
                        class="new bg-yellow-400 border border-gray-200 px-4 py-2 text-black rounded hover:bg-blue-600 hover:text-white flex items-center space-x-1">
                        {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                        <span class="hidden lg:inline ml-1">新規作成</span>
                    </a>
                </div>
            </div>

            <!-- 右側: 絞り込み + 検索 -->
            <div class="flex flex-col lg:flex-row items-end lg:items-center gap-4 mb-4">

                <!-- 講座選択 -->
                <form method="GET" action="{{ route('admin.questions.index') }}"
                    class="flex items-center space-x-2 lg:mb-0 justify-end gap-2" style="width: 850px;">

                    <select name="course_id" class="border px-2 py-1 rounded">
                        <option value="">全ての講座</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="tag_id" class="border px-2 py-1 rounded">
                        <option value="">全てのタグ</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>

                    <button class="text-white bg-emerald-600 px-3 py-2 rounded hover:bg-red-600">絞り込み</button>
                </form>

                <!-- 検索フォーム -->
                <div x-data="searchBox()" class="flex items-center space-x-2">
                    <form :action="url" method="GET" class="relative flex-1">
                        <input type="text" name="search" x-model="search" placeholder="タイトル・質問・答えで検索"
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
                        url: "{{ route('admin.questions.index') }}",
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
        {{-- {{ $questions->links() }} --}}

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <!-- No. -->
                        <th class="sort-cl border px-4 py-2 w-20 text-center">
                            {{-- No. --}}
                            <a href="{{ route('admin.questions.index', [
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

                        <!-- タグ -->
                        <th class="sort-cl border px-4 py-2 w-24">
                            {{-- タグ --}}
                            <a href="{{ route('admin.questions.index', [
                                'sort' => 'tag_id',
                                'direction' => $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                タグ
                                @if ($sort === 'tag_id')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>

                        <!-- 質問タイトル -->
                        <th class="border px-4 py-2 w-80">質問</th>

                        <!-- 対象講座 -->
                        <th class="sort-cl border px-4 py-2 w-40">
                            {{-- 対象講座 --}}
                            <a href="{{ route('admin.questions.index', [
                                'sort' => 'course_id',
                                'direction' => $sort === 'course_id' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                対象講座
                                @if ($sort === 'course_id')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>

                        <!-- 公開状態 -->
                        <th class="border px-4 py-2 w-24">表示</th>
                        <th class="sort-cl border px-4 py-2 w-40">
                            {{-- 更新日時 --}}
                            <a href="{{ route('admin.questions.index', [
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
                    @forelse ($questions as $question)
                        <tr class="hover:bg-gray-50">
                            <!-- No. -->
                            <td class="border px-4 py-2 text-center">
                                {{ ($questions->currentPage() - 1) * $questions->perPage() + $loop->iteration }}
                            </td>

                            <!-- タグ -->
                            <td class="border px-4 py-2">
                                {{ $question->tag->name ?? '-' }}
                            </td>

                            <!-- タイトル（詳細リンク） -->
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.questions.show', $question->id) }}"
                                    class="text-red-800 hover:underline">
                                    {{ $question->content }}
                                </a>
                            </td>

                            <!--  --講座名 -->
                            <td class="border px-4 py-2">
                                {{ $question->course->course_name ?? '全ての講座' }}
                            </td>

                            <!-- 表示状態 -->
                            <td class="border px-4 py-2 text-center">
                                @if ($question->is_show)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                        表示
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">
                                        非表示
                                    </span>
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center">
                                {{ $question->updated_at->format('Y/m/d H:i') }}</td>
                            <td class="border px-4 py-2 text-center">
                                {{ $question->updated_user_name }}
                            </td>

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
            {{ $questions->links() }}
        </div>

    </div>
@endsection
