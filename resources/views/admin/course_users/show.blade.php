@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">講座受講者詳細</h1>

        <div class="border p-4 rounded mb-6 space-y-2">
            <p>
                <strong>ユーザー名:</strong>
                {{ $CourseUser->user?->name ?? '-' }}
            </p>
            <p>
                <strong>講座名:</strong>
                {{ $CourseUser->course?->course_name ?? '-' }}
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.course_users.edit', $CourseUser->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                編集
            </a>
            <a href="{{ route('admin.course_users.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                一覧に戻る
            </a>
        </div>
    </div>
</div>
@endsection
