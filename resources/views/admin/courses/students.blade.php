@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-5xl">
    <h1 class="text-2xl font-bold mb-6">講座: {{ $course->course_name }} の受講生一覧</h1>

    {{-- 担当講師 --}}
    <div class="mb-4">
        <h2 class="text-lg font-semibold">担当講師</h2>
        @if($teachers->isEmpty())
        <p>担当講師は登録されていません</p>
        @else
        <ul class="list-disc ml-6">
            @foreach($teachers as $teacher)
            <li>{{ $teacher->name }}</li>
            @endforeach
        </ul>
        @endif
    </div>

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
                @php
                $statusMap = [
                0 => '非アクティブ',
                1 => 'アクティブ',
                2 => '停止',
                ];
                @endphp
                <td class="border px-4 py-2">
                    {{ $statusMap[$student->detail->status ?? ''] ?? '-' }}
                </td>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">受講生がいません</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>
@endsection
