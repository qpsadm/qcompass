@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-5xl">

    <h1 class="text-2xl font-bold mb-6">
        講座: {{ $course->course_name }} の受講生一覧
    </h1>

    {{-- 担当講師 --}}
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">担当講師</h2>

        @forelse($teachers as $teacher)
        <div class="text-sm text-gray-700">
            {{ $teacher->name }}（{{ $teacher->email }}）
        </div>
        @empty
        <p class="text-gray-500 text-sm">担当講師はいません</p>
        @endforelse
    </div>

    {{-- 受講生一覧 --}}
    <table class="w-full border-collapse border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 w-16">ID</th>
                <th class="border px-4 py-2">名前</th>
                <th class="border px-4 py-2">メール</th>
                <th class="border px-4 py-2 w-32">状態</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            @php
            $statusMap = [
            0 => '非アクティブ',
            1 => 'アクティブ',
            2 => '停止',
            ];
            @endphp
            <tr class="hover:bg-gray-50">
                <td class="border px-4 py-2">{{ $student->id }}</td>
                <td class="border px-4 py-2">{{ $student->name }}</td>
                <td class="border px-4 py-2">{{ $student->email }}</td>
                <td class="border px-4 py-2">
                    {{ $statusMap[$student->detail->status ?? null] ?? '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-6 text-gray-500">
                    受講生がいません
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ページネーション --}}
    <div class="mt-4">
        {{ $students->links('pagination::tailwind') }}
    </div>

</div>
@endsection
