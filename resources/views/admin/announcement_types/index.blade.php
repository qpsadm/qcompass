@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

    <h1 class="text-2xl font-bold mb-4 text-gray-800">お知らせカテゴリ一覧</h1>

    <!-- 上部操作 -->
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('admin.announcement_types.create') }}"
            class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center gap-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline">新規作成</span>
        </a>
    </div>

    <!-- ページネーション（上） -->
    <div class="mb-4">
        {{ $types->links() }}
    </div>

    <!-- 一覧テーブル -->
    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <!-- No.列（矢印なし） -->
                    <th class="border px-4 py-2 text-center w-12">
                        No.
                    </th>

                    <!-- ID列（ソート可能） -->
                    <th class="border px-4 py-2 text-center w-16">
                        <a href="{{ route('admin.announcement_types.index', ['sort' => 'id', 'direction' => ($sort==='id' && $direction==='asc') ? 'desc' : 'asc']) }}"
                            class="flex items-center justify-center gap-1 hover:underline">
                            ID
                            @if($sort==='id')
                            <span class="text-xs">{{ $direction==='asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>

                    <!-- 種別名 -->
                    <th class="border px-4 py-2">
                        <a href="{{ route('admin.announcement_types.index', ['sort' => 'type_name', 'direction' => ($sort==='type_name' && $direction==='asc') ? 'desc' : 'asc']) }}"
                            class="flex items-center gap-1 hover:underline">
                            種別名
                            @if($sort==='type_name')<span class="text-xs">{{ $direction==='asc' ? '▲' : '▼' }}</span>@endif
                        </a>
                    </th>

                    <!-- 表示 -->
                    <th class="border px-4 py-2 text-center w-24">
                        <a href="{{ route('admin.announcement_types.index', ['sort' => 'is_show', 'direction' => ($sort==='is_show' && $direction==='asc') ? 'desc' : 'asc']) }}"
                            class="flex items-center justify-center gap-1 hover:underline">
                            表示
                            @if($sort==='is_show')<span class="text-xs">{{ $direction==='asc' ? '▲' : '▼' }}</span>@endif
                        </a>
                    </th>
                </tr>
            </thead>


            <tbody>
                @forelse($types as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">
                        {{ ($types->currentPage()-1)*$types->perPage() + $loop->iteration }}
                    </td>
                    <td class="border px-4 py-2 text-center">{{ $item->id }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.announcement_types.edit', $item->id) }}"
                            class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            {{ $item->type_name }}
                        </a>
                    </td>
                    <td class="border px-4 py-2 text-center">
                        @if($item->is_show)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                        @else
                        <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="border px-4 py-6 text-center text-gray-500">データがありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ページネーション（下） -->
    <div class="mt-4">
        {{ $types->links() }}
    </div>

</div>
@endsection
