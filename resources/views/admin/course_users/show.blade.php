@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">ユーザー講座詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>ユーザーID:</strong> {{ $CourseUser->user_id }}</p>
            <p><strong>講座ID:</strong> {{ $CourseUser->course_id }}</p>
            <p><strong>削除日:</strong> {{ $CourseUser->deleted_at }}</p>

        </div>
        <a href="{{ route('admin.course_users.edit', $CourseUser->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('admin.course_users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
    @endsection
