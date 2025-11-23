@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-5xl">
    <h1 class="text-2xl font-bold mb-6">講座: {{ $course->course_name }} の受講生一覧</h1>

    <table class="w-full border-collapse border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 w-16">ID</th>
                <th class="border px-4 py-2">名前</th>
                <th class="border px-4 py-2">メール</th>
                <th class="border px-4 py-2">状態</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td class="border px-4 py-2">{{ $student->id }}</td>
                <td class="border px-4 py-2">{{ $student->name }}</td>
                <td class="border px-4 py-2">{{ $student->email }}</td>
                <td class="border px-4 py-2">{{ $student->detail->status ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4 text-gray-500">受講生がいません</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>
@endsection
