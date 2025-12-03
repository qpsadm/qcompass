@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">権限一覧</h1>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-center w-1/6">No.</th> <!-- 連番 -->
                    <th class="border px-4 py-2 text-center w-1/6">管理ID</th>
                    <th class="border px-4 py-2">役割名</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr class="hover:bg-gray-50">
                    <!-- ページをまたいでも連番 -->
                    <td class="border px-4 py-2 text-center">
                        {{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}
                    </td>
                    <td class="border px-4 py-2 text-center">{{ $role->id }}</td>
                    <td class="border px-4 py-2">{{ $role->role_name }}</td>
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

        <!-- ページネーション -->
        <div class="mt-4">
            {{ $roles->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
