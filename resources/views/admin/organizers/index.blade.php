@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4">講座開催者一覧</h1>

        <!-- 新規作成 -->
        <div class="flex justify-between mb-4">
            <a href="{{ route('admin.organizers.create') }}"
                class="new bg-yellow-400 border border-gray-200 px-4 py-2 text-black rounded hover:bg-blue-600 hover:text-white flex items-center space-x-1">
                {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>
        </div>

        <!-- ページネーション（上） -->
        {{-- {{ $organizers->links() }} --}}

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <!-- No. 並び替え -->
                        <th class="sort-cl border px-4 py-2 w-12 text-center w-20">
                            <a href="{{ route('admin.organizers.index', [
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

                        <!-- 開催者名 並び替え -->
                        <th class="border px-4 py-2 text-center">開催者名
                            {{-- <a href="{{ route('admin.organizers.index', [
                                'sort' => 'name',
                                'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center justify-center gap-1 hover:underline">

                                @if ($sort === 'name')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a> --}}
                        </th>
                        <th class="sort-cl border px-4 py-2 text-center w-40">
                            {{-- 更新日時 --}}
                            <a href="{{ route('admin.organizers.index', [
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
                        <th class="border px-4 py-2 text-center w-32">更新者名</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($organizers as $organizer)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">
                                {{ ($organizers->currentPage() - 1) * $organizers->perPage() + $loop->iteration }}
                            </td>

                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.organizers.edit', $organizer->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $organizer->name }}
                                </a>
                            </td>
                            <td class="border px-4 py-2 text-center">{{ $organizer->updated_at->format('Y/m/d H:i') }}</td>
                            <td class="border px-4 py-2 text-center">{{ $organizer->updated_user_name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="border px-4 py-2 text-center text-gray-500">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ページネーション（下） -->
        <div class="mt-4">
            {{ $organizers->links() }}
        </div>
    </div>
@endsection
