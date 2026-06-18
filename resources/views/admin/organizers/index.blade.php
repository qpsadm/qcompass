@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4">講座開催者一覧</h1>

        <!-- 新規作成 -->
        <div class="flex justify-between mb-4">
            <a href="{{ route('admin.organizers.create') }}"
                class="bg-blue-500 px-4 py-2 text-white rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
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
                        <th class="border px-4 py-2 w-12 text-center">
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
                        <th class="border px-4 py-2">
                            <a href="{{ route('admin.organizers.index', [
                                'sort' => 'name',
                                'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc',
                            ]) }}"
                                class="flex items-center gap-1 hover:underline">
                                開催者名
                                @if ($sort === 'name')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
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
