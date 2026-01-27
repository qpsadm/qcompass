@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

    <h1 class="text-2xl font-bold mb-4 text-gray-800">講座種類一覧</h1>

    <!-- 新規作成 -->
    <div class="flex justify-between mb-4">
        <a href="{{ route('admin.levels.create') }}"
            class="bg-blue-500 px-4 py-2 text-white rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">新規作成</span>
        </a>
    </div>

    <!-- ページネーション（上） -->
    {{ $levels->links() }}

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <!-- No.（IDソート） -->
                    <th class="border px-4 py-2 w-12 text-center">
                        <a href="{{ route('admin.levels.index', [
                                'sort' => 'id',
                                'direction' => ($sort === 'id' && $direction === 'asc') ? 'desc' : 'asc'
                            ]) }}"
                            class="flex items-center justify-center gap-1 hover:underline">
                            No.
                            @if ($sort === 'id')
                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>

                    <!-- レベルコード -->
                    <th class="border px-4 py-2 text-center w-1/6">
                        <a href="{{ route('admin.levels.index', [
                                'sort' => 'code',
                                'direction' => ($sort === 'code' && $direction === 'asc') ? 'desc' : 'asc'
                            ]) }}"
                            class="flex items-center justify-center gap-1 hover:underline">
                            レベルコード
                            @if ($sort === 'code')
                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>

                    <!-- 種類名 -->
                    <th class="border px-4 py-2">
                        <a href="{{ route('admin.levels.index', [
                                'sort' => 'name',
                                'direction' => ($sort === 'name' && $direction === 'asc') ? 'desc' : 'asc'
                            ]) }}"
                            class="flex items-center gap-1 hover:underline">
                            種類
                            @if ($sort === 'name')
                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>

                    <!-- 表示 -->
                    <th class="border px-4 py-2 text-center w-24">
                        <a href="{{ route('admin.levels.index', [
                                'sort' => 'is_show',
                                'direction' => ($sort === 'is_show' && $direction === 'asc') ? 'desc' : 'asc'
                            ]) }}"
                            class="flex items-center justify-center gap-1 hover:underline">
                            表示
                            @if ($sort === 'is_show')
                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($levels as $level)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">
                        {{ ($levels->currentPage() - 1) * $levels->perPage() + $loop->iteration }}
                    </td>

                    <td class="border px-4 py-2 text-center">
                        {{ $level->code }}
                    </td>

                    <!-- 名前クリック＝編集 -->
                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.levels.edit', $level->id) }}"
                            class="text-blue-600 hover:underline">
                            {{ $level->name }}
                        </a>
                    </td>

                    <td class="border px-4 py-2 text-center">
                        @if ($level->is_show)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                            表示
                        </span>
                        @else
                        <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">
                            非表示
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4"
                        class="border px-4 py-2 text-center text-gray-500">
                        データがありません
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ページネーション（下） -->
    <div class="mt-4">
        {{ $levels->links() }}
    </div>

</div>
@endsection
