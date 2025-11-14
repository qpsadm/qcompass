@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">CourseTeacher作成</h1>
    <form action="{{ route('course_teachers.store') }}" method="POST">
        @csrf
        <div class="mb-4">
    <label class="block font-medium mb-1">course_id</label>
    <input type="text" name="course_id" value="{{ old('course_id', $CourseTeacher->course_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">user_id</label>
    <input type="text" name="user_id" value="{{ old('user_id', $CourseTeacher->user_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">role_in_course</label>
    <input type="text" name="role_in_course" value="{{ old('role_in_course', $CourseTeacher->role_in_course ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
    </form>
</div>
@endsection