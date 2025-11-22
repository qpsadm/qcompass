@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{ open: false, deleteUrl: '', deleteName: '' }">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">講座カテゴリ一覧</h1>

    {{-- テーブル --}}
    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-4 py-2 text-center w-1/12">ID</th>
                    <th class="border px-4 py-2">講座名</th>
                    <th class="border px-4 py-2 text-center w-1/4">設定されているカテゴリ</th>
                    <th class="border px-4 py-2 text-center w-60">操作</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($courses as $course)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">{{ $course->id }}</td>
                    <td class="border px-4 py-2">{{ $course->course_name }}</td>

                    {{-- 設定されているカテゴリ --}}
                    <td class="border px-4 py-2 text-center">
                        @if ($course->categories->count())
                        <span class="text-gray-800">{{ $course->categories->pluck('name')->join(', ') }}</span>
                        @else
                        <span class="text-gray-400">カテゴリなし</span>
                        @endif
                    </td>

                    {{-- 操作 --}}
                    <td class="border px-4 py-2 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            {{-- カテゴリ設定 --}}
                            <a href="{{ route('admin.course_category.create', $course->id) }}"
                                class="flex items-center bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4 mr-1">
                                <span class="hidden lg:inline">カテゴリ設定</span>
                            </a>

                            {{-- 表示/非表示チェックボックス --}}
                            <form action="{{ route('admin.course_category.toggleShow', $course->id) }}" method="POST">
                                @csrf
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="hidden" name="is_show" value="0">
                                    <input type="checkbox" name="is_show" value="1"
                                        @checked($course->is_show ?? false)
                                    onchange="this.form.submit()">
                                    <span class="text-gray-700 text-sm">表示</span>
                                </label>
                            </form>

                            {{-- 削除 --}}
                            <button @click="open = true; deleteUrl='{{ route('admin.course_category.destroy', $course->id) }}'; deleteName='{{ $course->course_name }}';"
                                class="flex items-center text-red-600 hover:text-red-700">
                                <img src="{{ asset('assets/images/icon/b_dust.svg') }}" class="w-4 h-4 mr-1">
                                <span class="hidden lg:inline">削除</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                        データがありません
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 共通削除モーダル --}}
    <div x-show="open" x-cloak x-transition.opacity.duration.200ms
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div x-show="open" x-transition.scale.duration.200ms
            class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
            <p class="text-gray-700 text-center mb-5">
                「<span x-text="deleteName"></span>」を削除しますか？
            </p>
            <div class="flex justify-center space-x-4">
                <button @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    キャンセル
                </button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        削除する
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
@endsection
