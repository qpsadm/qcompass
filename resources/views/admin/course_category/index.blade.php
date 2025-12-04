@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4 text-gray-800">講座カテゴリ</h1>

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
                        <th class="border px-4 py-2 text-center w-1/12">No</th>

                        {{-- ソート付き 講座ID --}}
                        <th class="border px-4 py-2 text-center w-1/6">
                            <a href="{{ route('admin.course_category.index', ['sort' => 'id', 'order' => $nextOrder]) }}"
                                class="flex items-center justify-center space-x-1">
                                <span>講座ID</span>
                                @if ($sortColumn === 'id')
                                    @if ($order === 'asc')
                                        <span>▲</span>
                                    @else
                                        <span>▼</span>
                                    @endif
                                @endif
                            </a>
                        </th>

                        {{-- ソート付き 講座名 --}}
                        <th class="border px-4 py-2">
                            <a href="{{ route('admin.course_category.index', ['sort' => 'course_name', 'order' => $nextOrder]) }}"
                                class="flex items-center space-x-1">
                                <span>講座名</span>
                                @if ($sortColumn === 'course_name')
                                    @if ($order === 'asc')
                                        <span>▲</span>
                                    @else
                                        <span>▼</span>
                                    @endif
                                @endif
                            </a>
                        </th>

                        <th class="border px-4 py-2">設定されているカテゴリ</th>
                        <th class="border px-4 py-2 w-60 text-center">操作</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($courses as $index => $course)
                        <tr class="hover:bg-gray-50">

                            {{-- 連番（常に1〜） --}}
                            <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>

                            {{-- ID（DBのidそのまま） --}}
                            <td class="border px-4 py-2 text-center">{{ $course->id }}</td>

                            {{-- 講座名 --}}
                            <td class="border px-4 py-2">{{ $course->course_name }}</td>

                            {{-- カテゴリ --}}
                            <td class="border px-4 py-2">
                                @if ($course->categories->count())
                                    <span class="text-gray-800">{{ $course->categories->pluck('name')->join(', ') }}</span>
                                @else
                                    <span class="text-gray-400">カテゴリなし</span>
                                @endif
                            </td>

                            {{-- 操作 --}}
                            <td class="border px-4 py-2 text-center">
                                <div class="flex items-center justify-center space-x-2">

                                    <a href="{{ route('admin.course_category.edit', $course->id) }}"
                                        class="flex items-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition">
                                        <span>カテゴリ設定</span>
                                    </a>

                                    <a href="{{ route('admin.courses.agendas', ['course' => $course->id]) }}"
                                        class="flex items-center bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition">
                                        <span>アジェンダ</span>
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

    </div>
@endsection
