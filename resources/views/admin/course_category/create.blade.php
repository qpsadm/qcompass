@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">講座カテゴリ作成</h1>

            <form action="{{ route('admin.course_category.store') }}" method="POST">
                @csrf

                {{-- 講座ID --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">講座ID</label>
                    <input type="text" name="course_id" value="{{ old('course_id', $course->id) }}"
                        class="border px-2 py-1 w-full rounded" readonly>
                </div>

                {{-- カテゴリチェックボックス --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">カテゴリ選択</label>

                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($categories as $category)
                            <label class="flex items-center space-x-2 border p-2 rounded">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                                    @if (in_array($category->id, $selectedCategories)) checked @endif>
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- 備考 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">備考</label>
                    <input type="text" name="note" value="{{ old('note', '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">表示/非表示</label>
                    <select name="is_show" class="border px-2 py-1 w-full rounded">
                        <option value="1">表示</option>
                        <option value="0">非表示</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
            </form>
        </div>
    </div>
@endsection
