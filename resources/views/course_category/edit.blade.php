@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">講座カテゴリ編集</h1>
        <form action="{{ route('course_category.update', $CourseCategory->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">講座ID</label>
                <input type="text" name="course_id" value="{{ old('course_id', $CourseCategory->course_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">カテゴリID</label>
                <input type="text" name="category_id"
                    value="{{ old('category_id', $CourseCategory->category_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">備考</label>
                <input type="text" name="note" value="{{ old('note', $CourseCategory->note ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">表示/非表示</label>
                <input type="text" name="is_show" value="{{ old('is_show', $CourseCategory->is_show ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
@endsection
