@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4 text-gray-800">講座カテゴリ</h1>

        {{-- ■ 検索フォーム --}}
        <form method="GET" action="{{ route('admin.course_category.index') }}" class="mb-4 flex space-x-2 items-center">
            <div class="relative">
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="講座名で検索"
                    class="border px-3 py-2 rounded w-64 pr-8">

                {{-- ✕ ボタン（入力がある時だけ表示） --}}
                @if (request('keyword'))
                    <a href="{{ route('admin.course_category.index') }}"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 text-lg leading-none">
                        ×
                    </a>
                @endif
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                検索
            </button>
        </form>

        {{-- ■ ソート情報 --}}
        @php
            $sortColumn = request('sort', 'id');
            $order = request('order', 'desc');
            $nextOrder = $order === 'asc' ? 'desc' : 'asc';
        @endphp

        {{-- ■ テーブル --}}
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        {{-- 連番 --}}
                        <th class="border px-2 py-2 text-center w-16">No</th>

                        {{-- 講座ID（検索キーワード保持） --}}
                        <th class="border px-2 py-2 text-center w-20">
                            <a href="{{ route('admin.course_category.index', [
                                'sort' => 'id',
                                'order' => $nextOrder,
                                'keyword' => request('keyword'),
                            ]) }}"
                                class="flex items-center justify-center space-x-1">
                                <span>講座ID</span>
                                @if ($sortColumn === 'id')
                                    <span>{{ $order === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>

                        {{-- 講座名（検索キーワード保持） --}}
                        <th class="border px-4 py-2 w-1/3">
                            <a href="{{ route('admin.course_category.index', [
                                'sort' => 'course_name',
                                'order' => $nextOrder,
                                'keyword' => request('keyword'),
                            ]) }}"
                                class="flex items-center space-x-1">
                                <span>講座名</span>
                                @if ($sortColumn === 'course_name')
                                    <span>{{ $order === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>

                        <th class="border px-4 py-2 w-1/3">設定されているカテゴリ</th>
                        <th class="border px-4 py-2 w-60 text-center">操作</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($courses as $index => $course)
                        <tr class="hover:bg-gray-50">

                            {{-- 連番 --}}
                            <td class="border px-2 py-2 text-center w-16">
                                {{ ($courses->currentPage() - 1) * $courses->perPage() + ($index + 1) }}
                            </td>

                            {{-- 講座ID --}}
                            <td class="border px-2 py-2 text-center w-20">{{ $course->id }}</td>

                            {{-- 講座名 --}}
                            <td class="border px-4 py-2 w-1/3">{{ $course->course_name }}</td>

                            {{-- カテゴリ --}}
                            <td class="border px-4 py-2 w-1/3">
                                @if ($course->categories->count())
                                    {{ $course->categories->pluck('name')->join(', ') }}
                                @else
                                    <span class="text-gray-400">カテゴリなし</span>
                                @endif
                            </td>

                            {{-- 操作 --}}
                            <td class="border px-4 py-2 text-center w-60">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.course_category.edit', $course->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                        カテゴリ設定
                                    </a>

                                    <a href="{{ route('admin.courses.agendas', ['course' => $course->id]) }}"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                        アジェンダ
                                    </a>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border px-4 py-2 text-center text-gray-500">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $courses->appends(request()->query())->links('pagination::tailwind') }}
        </div>

    </div>
@endsection
