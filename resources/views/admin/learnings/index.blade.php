@php
    $tagLabels = [
        '1' => 'WEB制作',
        '2' => 'WEBデザイン',
        '3' => 'プログラミング',
        '4' => 'OA',
        '5' => 'その他',
    ];

    // $types = [
    //     'book' => '参考書籍',
    //     'site' => '参考サイト',
    //     'video' => 'IT資格',
    //     'article' => '制作品',
    // ];

    $types = [
        '1' => '参考書籍',
        '2' => '参考サイト',
        '3' => 'IT資格',
        '4' => '制作品',
    ];

    $levelLabels = ['1' => '初級', '2' => '中級', '3' => '上級'];

    /**
     * テーブルヘッダ用ソートリンク
     */
    function sort_link($label, $column)
    {
        $currentSort = request('sort', 'id');
        $currentDirection = request('direction', 'asc');

        $direction = $currentSort === $column && $currentDirection === 'asc' ? 'desc' : 'asc';

        $arrow = '';
        if ($currentSort === $column) {
            $arrow = $currentDirection === 'asc' ? ' ▲' : ' ▼';
        }

        $url = request()->fullUrlWithQuery([
            'sort' => $column,
            'direction' => $direction,
        ]);

        return '<a href="' .
            e($url) .
            '" class="flex items-center justify-center gap-1 hover:underline">' .
            e($label) .
            $arrow .
            '</a>';
    }
@endphp

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4">参考用コンテンツ一覧</h1>

        {{-- 上部操作・検索・絞り込み --}}
        <div class="flex items-center justify-between mb-4 space-x-2">

            {{-- 新規作成 --}}
            <a href="{{ route('admin.learnings.create') }}"
                class="new bg-yellow-400 border border-gray-200 px-4 py-2 text-black rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>

            {{-- 検索・絞り込み --}}
            <form method="GET" action="{{ route('admin.learnings.index') }}"
                class="flex items-center space-x-2 flex-1 justify-end gap-2">

                {{-- 種類 --}}
                <select name="type" class="border px-2 py-1 rounded">
                    <option value="">全ての種類</option>
                    @foreach ($types as $key => $label)
                        <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                {{-- タグ --}}
                <select name="tag_id" class="border px-2 py-1 rounded">
                    <option value="">全てのタグ</option>
                    {{-- @foreach ($tagLabels as $id => $label)
                        <option value="{{ $id }}" {{ request('tag_id') == $id ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach --}}
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>

                {{-- レベル --}}
                <select name="level" class="border px-2 py-1 rounded">
                    <option value="">全てのレベル</option>
                    @foreach ($levelLabels as $id => $label)
                        <option value="{{ $id }}" {{ request('level') == $id ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                {{-- 表示 --}}
                {{-- <select name="is_visible" class="border px-2 py-1 rounded">
                    <option value="">表示状態</option>
                    <option value="1" {{ request('is_visible') === '1' ? 'selected' : '' }}>表示</option>
                    <option value="0" {{ request('is_visible') === '0' ? 'selected' : '' }}>非表示</option>
                </select> --}}

                {{-- キーワード --}}
                <input type="text" name="search" value="{{ request('search') }}" placeholder="タイトル検索"
                    class="border px-2 py-1 rounded w-80">

                <button type="submit"
                    class="bg-blue-500 px-4 py-2 text-white rounded hover:bg-blue-600 hover:text-white transition">
                    検索
                </button>
                {{-- @if (request()->query())
                    <a href="{{ route('admin.learnings.index') }}"
                        class="bg-gray-300 px-4 py-1 rounded hover:bg-gray-400 transition">
                        リセット
                    </a>
                @endif --}}
            </form>
        </div>

        {{-- ページネーション（上） --}}
        {{-- <div class="mb-4">
        {{ $learnings->appends(request()->query())->links() }}
    </div> --}}

        {{-- テーブル --}}
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="sort-cl border px-2 py-2 text-center w-20">
                            {!! sort_link('No.', 'id') !!}
                        </th>

                        <th class="sort-cl border px-2 py-2 w-80">
                            {!! sort_link('タイトル', 'title') !!}
                        </th>
                        {{-- <th class="border px-4 py-2">説明</th> --}}
                        {{-- <th class="border px-4 py-2">画像</th> --}}
                        <th class="border px-2 py-2 w-20">参照URL</th>
                        <th class="sort-cl border px-2 py-2 w-32">
                            {!! sort_link('種類', 'type') !!}
                        </th>

                        <th class="sort-cl border px-2 py-2 w-40">
                            {{-- タグ（技術分野） --}}
                            {!! sort_link('タグ（技術分野）', 'tag_id') !!}
                        </th>
                        <th class="sort-cl border px-2 py-2 w-24">
                            {!! sort_link('レベル', 'level') !!}
                        </th>
                        <th class="border px-2 py-2 text-center w-20">
                            表示
                            {{-- {!! sort_link('表示', 'is_show') !!} --}}
                        </th>
                        <th class="sort-cl border px-2 py-2 w-40">
                            {!! sort_link('更新日時', 'updated_at') !!}
                        </th>
                        <th class="border px-2 py-2 w-32">更新者名</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($learnings as $learning)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-2 py-2 text-center">
                                {{ ($learnings->currentPage() - 1) * $learnings->perPage() + $loop->iteration }}
                            </td>

                            <td class="border px-2 py-2">
                                <a href="{{ route('admin.learnings.show', $learning->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $learning->title }}
                                </a>
                            </td>
                            {{-- <td class="border px-2 py-2">{{ Str::limit($learning->description, 50) }}</td> --}}
                            {{-- <td class="border px-2 py-2 text-center">
                                @if ($learning->image)
                                    <a href="{{ asset('storage/' . $learning->image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $learning->image) }}"
                                            class="w-12 h-12 object-cover mx-auto rounded">
                                    </a>
                                @else
                                    -
                                @endif
                            </td> --}}
                            <td class="border px-2 py-2 text-center">
                                @if ($learning->url)
                                    <a href="{{ $learning->url }}" target="_blank"
                                        class="text-blue-600 hover:underline">リンク</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border px-2 py-2">{{ $types[$learning->type] ?? '-' }}</td>

                            {{-- <td class="border px-2 py-2">{{ $tagLabels[$learning->tag_id] ?? '-' }}</td> --}}

                            <td class="border px-2 py-2">{{ $learning->tag->name }}</td>

                            <td class="border px-2 py-2 text-center">{{ $levelLabels[$learning->level] ?? '-' }}</td>

                            <td class="border px-2 py-2 text-center">
                                <span
                                    class="px-2 py-1 {{ $learning->is_show ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }} rounded-full text-xs">
                                    {{ $learning->is_show ? '表示' : '非表示' }}
                                </span>
                            </td>
                            <td class="border px-2 py-2 text-center">
                                {{ $learning->updated_at->format('Y/m/d H:i') }}</td>
                            <td class="border px-2 py-2 text-center">
                                {{ $learning->updated_user_name }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="border px-2 py-2 text-center text-gray-500">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ページネーション（下） --}}
        <div class="mt-4">
            {{ $learnings->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
