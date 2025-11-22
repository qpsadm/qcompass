@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{ open: false, deleteUrl: '', deleteName: '' }">
    <h1 class="text-2xl font-bold mb-4">社員一覧</h1>

    <div class="flex items-center justify-between mb-4">
        <!-- 新規作成 -->
        <a href="{{ route('admin.course_teachers.create') }}"
            class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">新規作成</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">講座名</th>
                    <th class="border px-4 py-2">講師名</th>
                    <th class="border px-4 py-2">担当区分</th>
                    <th class="border px-4 py-2 w-60 text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($course_teachers as $CourseTeacher)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $CourseTeacher->course?->course_name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $CourseTeacher->user?->name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $CourseTeacher->role_name ?? '-' }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex items-center justify-center flex-nowrap space-x-2">
                            <!-- 詳細 -->
                            <a href="{{ route('admin.course_teachers.show', $CourseTeacher->id) }}"
                                class="flex items-center text-green-600 hover:text-green-700">
                                <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">詳細</span>
                            </a>

                            <!-- 編集 -->
                            <a href="{{ route('admin.course_teachers.edit', $CourseTeacher->id) }}"
                                class="flex items-center text-blue-600 hover:text-blue-700">
                                <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">編集</span>
                            </a>

                            <!-- 削除 -->
                            <button @click="open = true; deleteUrl='{{ route('admin.course_teachers.destroy', $CourseTeacher->id) }}'; deleteName='{{ $CourseTeacher->user?->name ?? '削除対象' }}';"
                                class="flex items-center text-red-600 hover:text-red-700">
                                <img src="{{ asset('assets/images/icon/b_dust.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">削除</span>
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

    <!-- 共通削除モーダル -->
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
    <!-- /共通削除モーダル -->

</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection
