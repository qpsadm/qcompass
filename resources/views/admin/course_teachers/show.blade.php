@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">講座講師詳細</h1>

    <div class="bg-white shadow rounded-lg p-6 mb-4">
        <table class="w-full table-auto">
            <tbody>
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 w-1/4 text-right font-medium">講座名</th>
                    <td class="px-4 py-2">{{ $CourseTeacher->course?->course_name ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">講師名</th>
                    <td class="px-4 py-2">{{ $CourseTeacher->user?->name ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">担当区分</th>
                    <td class="px-4 py-2">{{ $CourseTeacher->role_name ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.course_teachers.edit', $CourseTeacher->id) }}"
            class="flex items-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
            <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
            <span class="ml-1">編集</span>
        </a>

        <a href="{{ route('admin.course_teachers.index') }}"
            class="flex items-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
            <span class="ml-1">一覧に戻る</span>
        </a>
    </div>
</div>
@endsection
