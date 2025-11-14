@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">CourseCategory詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>course_id:</strong> {{ $CourseCategory->course_id }}</p>
<p><strong>category_id:</strong> {{ $CourseCategory->category_id }}</p>
<p><strong>note:</strong> {{ $CourseCategory->note }}</p>
<p><strong>is_show:</strong> {{ $CourseCategory->is_show }}</p>

    </div>
    <a href="{{ route('course_category.edit', $CourseCategory->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('course_category.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection