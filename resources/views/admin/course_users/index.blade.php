@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4 text-gray-800">講座受講者一覧</h1>

        <!-- 新規作成 -->
        <div class="flex justify-between mb-4">
            <a href="{{ route('admin.course_users.create') }}"
                class="new bg-yellow-400 border border-gray-200 px-4 py-2 text-black rounded hover:bg-blue-600 transition flex items-center space-x-1">
                {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>
        </div>

        <!-- ページネーション（上） -->
        {{-- <div class="mb-3">
        {{ $courseUsers->links() }}
    </div> --}}

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 w-12 text-center">No.</th>
                        <th class="border px-4 py-2">ユーザー名</th>
                        <th class="border px-4 py-2">講座名</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($courseUsers as $courseUser)
                        <tr class="hover:bg-gray-50">

                            <!-- No. -->
                            <td class="border px-4 py-2 text-center">
                                {{ ($courseUsers->currentPage() - 1) * $courseUsers->perPage() + $loop->iteration }}
                            </td>

                            <!-- ユーザー名 -->
                            <td class="border px-4 py-2">
                                @if ($courseUser->user)
                                    <a href="{{ route('admin.course_users.edit', $courseUser->id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $courseUser->user->name }}
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">
                                        削除済みユーザー
                                    </span>
                                @endif
                            </td>

                            <!-- 講座名 -->
                            <td class="border px-4 py-2">
                                @if ($courseUser->course)
                                    {{ $courseUser->course->course_name }}
                                @else
                                    <span class="text-gray-400 italic">
                                        削除済み講座
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border px-4 py-6 text-center text-gray-500">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ページネーション（下） -->
        <div class="mt-4">
            {{ $courseUsers->links() }}
        </div>

    </div>
@endsection
