@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">講座カテゴリ詳細</h1>
            <div class="border p-4 rounded mb-4">
                <p><strong>講座ID:</strong> {{ $CourseCategory->course_id }}</p>
                <p><strong>カテゴリID:</strong> {{ $CourseCategory->category_id }}</p>
                <p><strong>備考:</strong> {{ $CourseCategory->note }}</p>
                <p><strong>表示/非表示:</strong> {{ $CourseCategory->is_show }}</p>

            </div>
            <a href="{{ route('admin.course_category.edit', $CourseCategory->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('admin.course_category.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
        </div>
    @endsection
