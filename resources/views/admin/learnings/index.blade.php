@php
$tagLabels = [
1 => 'WEB制作',
2 => 'WEBデザイン',
3 => 'プログラミング',
4 => 'OA',
];

$types = [
'book' => '参考書籍',
'site' => '参考サイト',
'video' => 'IT資格',
'article' => '製作品',
'other' => 'その他',
];

$levelLabels = [1 => '初級', 2 => '中級', 3 => '上級'];
@endphp

@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

    <h1 class="text-2xl font-bold mb-4">学習コンテンツ一覧</h1>

    {{-- 新規作成 --}}
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('admin.learnings.create') }}"
            class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">新規作成</span>
        </a>
    </div>

    {{-- ページネーション（上） --}}
    <div class="mb-4">
        {{ $learnings->links() }}
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-center w-12">No.</th>
                    <th class="border px-4 py-2">種類</th>
                    <th class="border px-4 py-2">タイトル</th>
                    <th class="border px-4 py-2">説明</th>
                    <th class="border px-4 py-2">画像</th>
                    <th class="border px-4 py-2">URL</th>
                    <th class="border px-4 py-2">レベル</th>
                    <th class="border px-4 py-2">タグ</th>
                    <th class="border px-4 py-2 text-center">表示</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($learnings as $learning)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">
                        {{ ($learnings->currentPage() - 1) * $learnings->perPage() + $loop->iteration }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $types[$learning->type] ?? '-' }}
                    </td>

                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.learnings.show', $learning->id) }}"
                            class="text-blue-600 hover:underline">
                            {{ $learning->title }}
                        </a>
                    </td>

                    <td class="border px-4 py-2">
                        {{ Str::limit($learning->description, 50) }}
                    </td>

                    <td class="border px-4 py-2 text-center">
                        @if ($learning->image)
                        <a href="{{ asset('storage/'.$learning->image) }}" target="_blank"
                            class="inline-block w-12 h-12 bg-gray-100 rounded overflow-hidden border hover:ring-2 hover:ring-blue-400">
                            <img src="{{ asset('storage/'.$learning->image) }}" class="w-full h-full object-cover">
                        </a>
                        @else
                        -
                        @endif
                    </td>

                    <td class="border px-4 py-2 text-center">
                        @if ($learning->url)
                        <a href="{{ $learning->url }}" target="_blank" class="text-blue-600 hover:underline">
                            リンク
                        </a>
                        @else
                        -
                        @endif
                    </td>

                    <td class="border px-4 py-2">
                        {{ $levelLabels[$learning->level] ?? '-' }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $tagLabels[$learning->tag_id] ?? '-' }}
                    </td>

                    <td class="border px-4 py-2 text-center">
                        <span class="px-2 py-1 {{ $learning->is_visible ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }} rounded-full text-xs">
                            {{ $learning->visible_label }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="border px-4 py-2 text-center text-gray-500">
                        データがありません
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ページネーション（下） --}}
        <div class="mt-4">
            {{ $learnings->links() }}
        </div>
    </div>

</div>

@endsection
