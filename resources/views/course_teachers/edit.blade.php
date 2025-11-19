@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">講座講師編集</h1>
        <form action="{{ route('course_teachers.update', $CourseTeacher->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">講座ID</label>
                <input type="text" name="course_id" value="{{ old('course_id', $CourseTeacher->course_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">講師のユーザーID</label>
                <input type="text" name="user_id" value="{{ old('user_id', $CourseTeacher->user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">担当区分</label>
                <input type="text" name="role_in_course"
                    value="{{ old('role_in_course', $CourseTeacher->role_in_course ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
@endsection
