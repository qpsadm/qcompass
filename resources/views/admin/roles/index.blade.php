@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">権限一覧</h1>
        <!-- ページネーション（上） -->
        {{-- <div class="mb-4">
        {{ $roles->links() }}
    </div> --}}

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="sort-cl border px-4 py-2 text-center w-20">
                            {{-- No. --}}
                            <a href="{{ route('admin.roles.index', [
                                'sort' => 'id',
                                'direction' => $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                No.
                                @if ($sort === 'id')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 text-center w-24">管理ID</th>
                        <th class="border px-4 py-2">役割名</th>
                        <th class="sort-cl border px-4 py-2 w-40">
                            {{-- 更新日時 --}}
                            <a href="{{ route('admin.roles.index', [
                                'sort' => 'updated_at',
                                'direction' => $sort === 'updated_at' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center justify-center gap-1 hover:underline">
                                更新日時
                                @if ($sort === 'updated_at')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-32">更新者名</th>
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
                            <td class="border px-4 py-2 text-center">{{ $role->updated_at->format('Y/m/d H:i') }}</td>
                            <td class="border px-4 py-2">{{ $role->updated_user_name }}</td>
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
