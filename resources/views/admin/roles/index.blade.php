@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">権限一覧</h1>

    <!-- 上部操作エリア -->
    <div class="flex items-center justify-between mb-4">
        <!-- 新規作成 -->
        <a href="{{ route('admin.roles.create') }}"
            class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">新規作成</span>
        </a>
    </div>

    <!-- ページネーション（上） -->
    <div class="mb-4">
        {{ $roles->links() }}
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-center w-12">No.</th>
                    <th class="border px-4 py-2 text-center w-24">管理ID</th>
                    <th class="border px-4 py-2">役割名</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr class="hover:bg-gray-50">
                    <!-- 連番（ページ跨ぎ対応） -->
                    <td class="border px-4 py-2 text-center">
                        {{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}
                    </td>

                    <td class="border px-4 py-2 text-center">
                        {{ $role->id }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $role->role_name }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="border px-4 py-2 text-center text-gray-500">
                        データがありません
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- ページネーション（下） -->
        <div class="mt-4">
            {{ $roles->links() }}
        </div>
    </div>
</div>
@endsection
