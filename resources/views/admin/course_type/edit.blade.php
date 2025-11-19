@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">講座分野編集</h1>
        <form action="{{ route('admin.course_type.update', $CourseType->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block font-medium mb-1">名前</label>
                <input type="text" name="name" id="name" value="{{ old('name', $CourseType->name ?? '') }}"
                       class="border-gray-300 border px-2 py-1 w-[300px] rounded-md
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                更新
            </button>
        </form>
    </div>
</div>
@endsection
