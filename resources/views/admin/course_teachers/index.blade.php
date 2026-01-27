@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

    <h1 class="text-2xl font-bold mb-4 text-gray-800">講座講師一覧</h1>

    <!-- 新規作成ボタン -->
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('admin.course_teachers.create') }}"
            class="bg-blue-500 px-4 py-2 text-white rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">新規作成</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-4 py-2 text-center w-12">No.</th>
                    <th class="border px-4 py-2">講座名</th>
                    <th class="border px-4 py-2">講師名</th>
                    <th class="border px-4 py-2">担当区分</th>
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
