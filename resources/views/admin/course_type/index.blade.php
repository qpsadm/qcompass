@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4" x-data="{ openModal: null }"> {{-- Alpine.js管理 --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">講座分野一覧</h1>
            <a href="{{ route('admin.course_type.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

            <table class="table-auto border-collapse border w-full">
                <thead>
                    <tr>
                        <th class='border px-4 py-2'>名前</th>
                        <th class='border px-4 py-2'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($course_type as $CourseType)
                        <tr>
                            <td class='border px-4 py-2'>{{ $CourseType->name }}</td>
                            <td class='border px-4 py-2'>
                                <a href="{{ route('admin.course_type.show', $CourseType->id) }}"
                                    class="text-green-600">詳細</a>
                                <a href="{{ route('admin.course_type.edit', $CourseType->id) }}"
                                    class="text-blue-600 ml-2">編集</a>

                                {{-- 削除ボタン --}}
                                <button @click="openModal = {{ $CourseType->id }}" class="text-red-600 ml-2">
                                    削除
                                </button>

                                {{-- モーダル --}}
                                <div x-show="openModal === {{ $CourseType->id }}"
                                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
                                    <div class="bg-white rounded-lg p-6 w-96">
                                        <h2 class="text-lg font-bold mb-4">確認</h2>
                                        <p class="mb-6">本当に削除しますか？</p>
                                        <div class="flex justify-end gap-2">
                                            <button @click="openModal = null"
                                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">キャンセル</button>

                                            <form action="{{ route('admin.course_type.destroy', $CourseType->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                                    削除
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- /モーダル --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
