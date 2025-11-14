@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">CourseUser詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>user_id:</strong> {{ $CourseUser->user_id }}</p>
<p><strong>course_id:</strong> {{ $CourseUser->course_id }}</p>
<p><strong>deleted_at:</strong> {{ $CourseUser->deleted_at }}</p>

    </div>
    <a href="{{ route('course_user.edit', $CourseUser->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('course_user.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection