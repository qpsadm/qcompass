@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">講座講師詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>講座ID:</strong> {{ $CourseTeacher->course_id }}</p>
            <p><strong>講師のユーザーID:</strong> {{ $CourseTeacher->user_id }}</p>
            <p><strong>担当区分:</strong> {{ $CourseTeacher->role_in_course }}</p>

        </div>
        <a href="{{ route('course_teachers.edit', $CourseTeacher->id) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('course_teachers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection
