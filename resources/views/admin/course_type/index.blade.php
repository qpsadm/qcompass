@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen">

    <div class="bg-white rounded-lg shadow-md p-6">

        <h1 class="text-2xl font-bold mb-4 text-gray-800">
            講座分野一覧
        </h1>

        <!-- 新規作成 -->
        <div class="flex justify-between mb-4">
            <a href="{{ route('admin.course_type.create') }}"
                class="bg-blue-500 px-4 py-2 text-white rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>
        </div>

        <!-- ページネーション（上） -->
        {{ $course_types->links() }}

        <div class="overflow-x-auto mt-4">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-2 w-12 text-center">
                            No.
                        </th>
                        <th class="border px-4 py-2">
                            分野名
                        </th>
                        <th class="border px-4 py-2">
                            実施団体
                        </th>
                        <th class="border px-4 py-2 text-center w-24">
                            表示
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($course_types as $courseType)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">
                            {{ ($course_types->currentPage() - 1) * $course_types->perPage() + $loop->iteration }}
                        </td>

                        <!-- 名前クリックで編集 -->
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.course_type.edit', $courseType->id) }}"
                                class="text-blue-600 hover:underline">
                                {{ $courseType->name }}
                            </a>
                        </td>

                        <td class="border px-4 py-2">
                            {{ $courseType->organizer->name ?? '-' }}
                        </td>

                        <td class="border px-4 py-2 text-center">
                            @if ($courseType->is_show)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                表示
                            </span>
                            @else
                            <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">
                                非表示
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4"
                            class="border px-4 py-2 text-center text-gray-500">
                            データがありません
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ページネーション（下） -->
        <div class="mt-4">
            {{ $course_types->links() }}
        </div>

    </div>
</div>
@endsection
