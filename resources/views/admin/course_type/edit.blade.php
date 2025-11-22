@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">講座分野編集</h1>
        <form action="{{ route('admin.course_type.update', $CourseType->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- 名前 --}}
            <div class="mb-4">
                <label for="name" class="block font-medium mb-1">名前</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $CourseType->name ?? '') }}"
                    class="border-gray-300 border px-2 py-1 w-[300px] rounded-md
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- 表示設定 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">表示設定</label>

                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_show" value="0">
                    <input type="checkbox" name="is_show" value="1"
                        @checked(old('is_show', $CourseType->is_show))>
                    <span class="text-gray-700">表示する</span>
                </label>
            </div>

            <div class="flex gap-2 mt-2">
                <!-- 保存ボタン -->
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                    保存
                </button>

                <!-- 一覧に戻るボタン -->
                <a href="{{ route('admin.course_type.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
