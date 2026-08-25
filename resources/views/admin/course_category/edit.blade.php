@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">講座のカテゴリ設定（{{ $course->course_name }}）</h1>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.course_category.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- カテゴリ選択 --}}
                <div class="mb-4 grid grid-cols-1 gap-2">
                    @foreach ($categories as $category)
                        <div
                            class="flex flex-row items-center space-x-2 border px-3 py-2 rounded cursor-pointer hover:bg-gray-300 w-full">
                            <div class="w-1/2">
                                @if (!is_null($category->parent_id))
                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                @endif
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                                    @if (in_array($category->id, $selectedCategories)) checked @endif
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <span>
                                    {{ $category->name }} ({{ $category->code }})
                                </span>
                            </div>
                            <div class="w-20">
                                @if ($category->is_show)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                                @endif
                            </div>
                            <div>
                                アジェンダ：{{ $category->agendas_count }} 件
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- メモ --}}
                <div class="mb-4">
                    <label for="note" class="block mb-1 font-medium">メモ</label>
                    <input type="text" name="note" id="note" placeholder="備考を記入"
                        value="{{ old('note', $course->note ?? '') }}"
                        class="border border-gray-300 px-3 py-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- 公開/非公開 --}}
                <div class="mb-6">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="hidden" name="is_show" value="0">
                        <input type="checkbox" name="is_show" value="1" @checked(old('is_show', $course->is_show ?? 1))
                            class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="text-gray-700 font-medium">表示する</span>
                    </label>
                </div>

                {{-- ボタン --}}
                <div class="flex gap-2">
                    <button type="submit"
                        class="save bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                        更新
                    </button>
                    <a href="{{ route('admin.course_category.index') }}"
                        class="back bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                        一覧に戻る
                    </a>
                </div>

            </form>
        </div>
    </div>
@endsection
