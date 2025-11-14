@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">CourseTeacher詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>course_id:</strong> {{ $CourseTeacher->course_id }}</p>
<p><strong>user_id:</strong> {{ $CourseTeacher->user_id }}</p>
<p><strong>role_in_course:</strong> {{ $CourseTeacher->role_in_course }}</p>

    </div>
    <a href="{{ route('course_teachers.edit', $CourseTeacher->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('course_teachers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection