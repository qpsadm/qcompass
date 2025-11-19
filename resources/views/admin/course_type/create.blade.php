@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">講座分野作成</h1>
            <form action="{{ route('admin.course_type.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium mb-1">名前</label>
                    <input type="text" name="name" value="{{ old('name', $CourseType->name ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
            </form>
        </div>
    @endsection
