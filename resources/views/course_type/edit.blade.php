@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">講座分野編集</h1>

            <form action="{{ route('course_type.update', $CourseType->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-1">講座名</label>
                    <input type="text" name="name" value="{{ old('name', $CourseType->name ?? '') }}"
                        class="border px-2 py-1 w-40 rounded">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                        更新
                    </button>
                    <a href="{{ route('course_type.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
