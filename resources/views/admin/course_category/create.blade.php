@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">講座カテゴリ作成</h1>

        <form action="{{ route('admin.course_category.store') }}" method="POST">
            @csrf

            {{-- 講座名 --}}
            <div class="mb-4">
                <label class="block font-medium mb-2">講座</label>
                <input type="text" value="{{ $course->course_name }}"
                    class="border border-gray-300 px-3 py-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    readonly>
            </div>

            <input type="hidden" name="course_id" value="{{ $course->id }}">

            {{-- カテゴリ選択 --}}
            <div class="mb-4">
                <label class="block font-medium mb-2">カテゴリ選択</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($categories as $category)
                    <label class="flex items-center space-x-2 border px-3 py-2 rounded cursor-pointer hover:bg-gray-50">
                        <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                            @if (in_array($category->id, $selectedCategories)) checked @endif
                        class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span>{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- 備考 --}}
            <div class="mb-4">
                <label class="block font-medium mb-2">備考</label>
                <input type="text" name="note" value="{{ old('note', '') }}"
                    class="border border-gray-300 px-3 py-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- 表示フラグ --}}
            <div class="mb-6">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="hidden" name="is_show" value="0">
                    <input type="checkbox" name="is_show" value="1"
                        @checked(old('is_show', 1))
                        class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-gray-700 font-medium">表示する</span>
                </label>
            </div>

            {{-- ボタン群 --}}
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                    保存
                </button>

                <a href="{{ route('admin.course_category.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                    一覧に戻る
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
