@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

    @php
    function sortLink($label, $column) {
    $direction = request('direction') === 'asc' ? 'desc' : 'asc';
    if (request('sort') !== $column) {
    $direction = 'asc';
    }

    $query = array_merge(request()->query(), [
    'sort' => $column,
    'direction' => $direction,
    ]);

    $arrow = '';
    if (request('sort') === $column) {
    $arrow = request('direction') === 'asc' ? ' ▲' : ' ▼';
    }

    return '<a href="'.route('admin.announcements.index', $query).'" class="hover:underline">'
        .$label.$arrow.'</a>';
    }
    @endphp

    <h1 class="text-2xl font-bold mb-4">お知らせ一覧</h1>

    {{-- 上部操作・検索・絞り込み --}}
    <div class="flex items-center justify-between mb-4 space-x-2">

        {{-- 新規作成 --}}
        <a href="{{ route('admin.announcements.create') }}"
            class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span>新規作成</span>
        </a>


        {{-- 絞り込み --}}
        <form method="GET" action="{{ route('admin.announcements.index') }}"
            class="flex items-center space-x-2 flex-1 justify-end">

            {{-- カテゴリー --}}
            <select name="category_id" class="border px-2 py-1 rounded">
                <option value="">全カテゴリー</option>
                @foreach ($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->type_name }}
                </option>
                @endforeach
            </select>

            {{-- 講座（★追加） --}}
            <select name="course_id" class="border px-2 py-1 rounded">
                <option value="">全講座</option>
                @foreach ($courses as $course)
                <option value="{{ $course->id }}"
                    {{ request('course_id') == $course->id ? 'selected' : '' }}>
                    {{ $course->course_name }}
                </option>
                @endforeach
            </select>

            {{-- 状態 --}}
            <select name="status" class="border px-2 py-1 rounded">
                <option value="">全状態</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>下書き</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>承認待ち</option>
                <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>承認済み</option>
            </select>

            {{-- 検索 --}}
            <input type="text" name="search"
                value="{{ request('search') }}"
                placeholder="タイトル検索"
                class="border px-2 py-1 rounded w-60">

            <button type="submit"
                class="bg-blue-500 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition">
                絞り込み
            </button>
        </form>
    </div>

    {{-- ページネーション（上） --}}
    <div class="mb-4">
        {{ $announcements->links() }}
    </div>

    {{-- テーブル --}}
    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-center w-12">No.</th>
                    <th class="border px-4 py-2">{!! sortLink('タイトル', 'title') !!}</th>
                    <th class="border px-4 py-2">カテゴリー</th>
                    <th class="border px-4 py-2">講座</th>
                    <th class="border px-4 py-2 text-center">表示</th>
                    <th class="border px-4 py-2">{!! sortLink('状態', 'status') !!}</th>
                    <th class="border px-4 py-2">作成者</th>
                    <th class="border px-4 py-2">{!! sortLink('作成日', 'created_at') !!}</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($announcements as $announcement)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">
                        {{ ($announcements->currentPage() - 1) * $announcements->perPage() + $loop->iteration }}
                    </td>

                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.announcements.show', $announcement->id) }}"
                            class="text-blue-600 hover:underline">
                            {{ $announcement->title }}
                        </a>
                    </td>

                    <td class="border px-4 py-2">
                        {{ $announcement->type->type_name ?? '未分類' }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $announcement->course?->course_name ?? '全体向け' }}
                    </td>

                    <td class="border px-4 py-2 text-center">
                        <span class="px-2 py-1 rounded-full text-xs
                            {{ $announcement->is_show ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $announcement->is_show ? '表示' : '非表示' }}
                        </span>
                    </td>

                    <td class="border px-4 py-2">
                        {{ ['下書き','承認待ち','承認済み'][$announcement->status] }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $announcement->created_user_name ?? '-' }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $announcement->created_at->format('Y-m-d') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="border px-4 py-6 text-center text-gray-500">
                        お知らせはありません
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ページネーション（下） --}}
    <div class="mt-4">
        {{ $announcements->links() }}
    </div>

</div>
@endsection
