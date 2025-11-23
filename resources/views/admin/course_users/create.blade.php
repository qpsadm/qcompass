@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">ユーザー講座作成</h1>
        <form action="{{ route('admin.course_users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-medium mb-1">ユーザーID</label>
                <input type="text" name="user_id" value="{{ old('user_id', $CourseUser->user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">講座ID</label>
                <input type="text" name="course_id" value="{{ old('course_id', $CourseUser->course_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>

            <a href="{{ route('admin.course_users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
        </form>
    </div>
    @endsection
