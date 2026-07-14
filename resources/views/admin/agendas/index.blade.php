@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4">アジェンダ一覧</h1>

        {{-- 上部操作・検索・絞り込み --}}
        <div class="flex items-center justify-between mb-4 space-x-2">

            {{-- 新規作成 --}}
            <a href="{{ route('admin.agendas.create') }}"
                class="bg-yellow-400 border border-gray-200 px-4 py-2 text-black rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>

            {{-- 絞り込みフォーム --}}
            <form method="GET" action="{{ route('admin.agendas.index') }}"
                class="flex items-center space-x-2 flex-1 justify-end">

                {{-- カテゴリー --}}
                <select name="category_id" class="border px-2 py-2 rounded">
                    <option value="">全てのカテゴリー</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                {{-- ステータス --}}
                <select name="status" class="border px-2 py-2 rounded">
                    <option value="">全てのステータス</option>
                    <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>承認済み</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>下書き</option>
                </select>

                {{-- キーワード --}}
                <input type="text" name="search" value="{{ request('search') }}" placeholder="アジェンダ名で検索"
                    class="border px-2 py-2 rounded w-60">

                {{-- 検索ボタン --}}
                <button type="submit" class="bg-blue-500 px-4 py-2 text-white rounded hover:bg-blue-600 transition">
                    検索
                </button>

                {{-- リセットボタン --}}
                @if (request()->query())
                    <a href="{{ route('admin.agendas.index') }}"
                        class="bg-gray-300 px-4 py-1 text-gray-800 rounded hover:bg-gray-400 transition">
                        リセット
                    </a>
                @endif
            </form>

        </div>

        {{-- ページネーション（上） --}}
        {{-- <div class="mb-4">
        {{ $agendas->appends(request()->query())->links() }}
    </div> --}}

        {{-- テーブル --}}
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        @php
                            $directionToggle = request('direction') === 'asc' ? 'desc' : 'asc';
                        @endphp

                        <th class="border px-4 py-2 w-12" style="background-color: #2563eb;">
                            <a
                                href="{{ route('admin.agendas.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => $directionToggle])) }}">
                                No.
                                @if ($sort === 'id')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-48">アジェンダ名</th>
                        <th class="border px-4 py-2 w-32">カテゴリー
                            @if ($sort === 'category_id')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-20">表示</th>
                        <th class="border px-4 py-2 w-20" style="background-color: #2563eb;">
                            <a
                                href="{{ route('admin.agendas.index', array_merge(request()->all(), ['sort' => 'status', 'direction' => $directionToggle])) }}">
                                承認
                                @if ($sort === 'status')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-20">作成者</th>
                        <th class="border px-4 py-2 w-24">作成日</th>
                        <th class="border px-4 py-2 w-24" style="background-color: #2563eb;">
                            <a
                                href="{{ route('admin.agendas.index', array_merge(request()->all(), ['sort' => 'updated_at', 'direction' => $directionToggle])) }}">
                                更新日
                                @if ($sort === 'updated_at')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($agendas as $agenda)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">
                                {{ ($agendas->currentPage() - 1) * $agendas->perPage() + $loop->iteration }}
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.agendas.show', $agenda->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $agenda->agenda_name }}
                                </a>
                            </td>
                            <td class="border px-4 py-2">
                                {{ $agenda->category->name ?? '未分類' }}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                @if ($agenda->is_show)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center">
                                @if ($agenda->status === 'yes')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">承認済み</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">下書き</span>
                                @endif


                            </td>
                            <td class="border px-4 py-2">{{ $agenda->created_user_name ?? '-' }}</td>
                            <td class="border px-4 py-2 text-center">{{ $agenda->created_at->format('Y-m-d H:i') }}</td>
                            <td class="border px-4 py-2 text-center">{{ $agenda->updated_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border px-4 py-2 text-center text-gray-500">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- ページネーション（下） --}}
        <div class="mt-4">
            {{ $agendas->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
