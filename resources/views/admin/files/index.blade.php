{{-- resources/views/admin/files/index.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container p-6 bg-white rounded-lg shadow-md">

        @php
            // タイプごとの日本語タイトル
            $titles = [
                'agenda' => 'アジェンダ',
                'announcement' => 'お知らせ',
            ];
            $japaneseTitle = $titles[$type] ?? 'ファイル';
        @endphp

        <h1 class="text-2xl font-bold mb-4">{{ $japaneseTitle }} ファイル一覧</h1>

        {{-- 上部操作・検索・絞り込み --}}
        <div class="flex items-center justify-between mb-4 space-x-2">

            {{-- 新規作成ボタンは targetId がある場合のみ --}}
            @if (!empty($targetId))
                <div class="mb-4">
                    <a href="{{ route('admin.files.create', ['type' => $type, 'targetId' => $targetId]) }}"
                        class="new bg-yellow-400 border border-gray-200 text-black px-4 py-2 rounded hover:bg-blue-600">
                        新規作成
                    </a>
                </div>
            @endif

            {{-- 絞り込みフォーム --}}
            <form method="GET" action="{{ route('admin.files.index', ['type' => $type, 'targetId' => $targetId]) }}"
                class="flex items-center space-x-2 flex-1 justify-end">

                {{-- 現在のソート条件を維持したい場合の隠しフィールド --}}
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if (request('direction'))
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif

                {{-- キーワード入力 --}}
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="{{ $type === 'agenda' ? 'ファイル名またはアジェンダ名で検索' : ($type === 'announcement' ? 'ファイル名またはお知らせタイトルで検索' : 'ファイル名で検索') }}"
                    class="border px-2 py-2 rounded w-80">

                {{-- 検索ボタン --}}
                <button type="submit" class="bg-blue-600 px-4 py-2 text-white rounded hover:bg-blue-700 transition">
                    検索
                </button>

                {{-- リセットボタン（検索キーワード等がある時のみ表示） --}}
                {{-- @if (request('search'))
                    <a href="{{ route('admin.files.index', ['type' => $type, 'targetId' => $targetId]) }}"
                        class="bg-gray-300 px-4 py-2 text-gray-800 rounded hover:bg-gray-400 transition">
                        リセット
                    </a>
                @endif --}}
            </form>

        </div>

        @if ($files->isEmpty())
            <p>ファイルはまだ登録されていません。</p>
        @else
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        @php
                            $directionToggle = request('direction') === 'asc' ? 'desc' : 'asc';
                        @endphp

                        {{-- No. (ID) --}}
                        <th class="sort-cl border px-4 py-2 w-20">
                            <a
                                href="{{ route('admin.files.index', array_merge(request()->all(), ['type' => $type, 'targetId' => $targetId, 'sort' => 'id', 'direction' => $directionToggle])) }}">
                                No.
                                @if ($sort === 'id')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>

                        <th class="border px-4 py-2 w-40">ファイル名</th>
                        <th class="border px-4 py-2 w-32">種類</th>
                        <th class="border px-4 py-2 w-60">
                            {{ $type === 'agenda' ? 'アジェンダ名' : ($type === 'announcement' ? 'お知らせ名' : '対象名') }}
                        </th>
                        <th class="border px-4 py-2 w-32">サイズ</th>
                        {{-- <th class="border px-4 py-2 w-40">説明</th> --}}
                        {{-- 更新日時 列の並び替え --}}

                        <th class="sort-cl border px-4 py-2 w-40">
                            <a
                                href="{{ route('admin.files.index', array_merge(request()->all(), ['type' => $type, 'targetId' => $targetId, 'sort' => 'updated_at', 'direction' => $directionToggle])) }}">
                                更新日
                                @if ($sort === 'updated_at')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="border px-4 py-2 w-32">更新者名</th>
                        <th class="border px-4 py-2 w-60">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $file->file_name }}</td>
                            <td class="border px-4 py-2">{{ $file->file_type }}</td>

                            {{-- 属するアジェンダまたはお知らせの投稿名（リンク付き） --}}
                            <td>
                                @if ($file->target)
                                    @if ($file->target instanceof \App\Models\Agenda)
                                        <a href="{{ route('admin.agendas.edit', $file->target_id) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $file->target->display_title }}
                                        </a>
                                    @elseif ($file->target instanceof \App\Models\Announcement)
                                        <a href="{{ route('admin.announcements.edit', $file->target_id) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $file->target->display_title }}
                                        </a>
                                    @endif
                                @else
                                    <span class="text-gray-400">（削除された投稿）</span>
                                @endif
                            </td>

                            <td class="border px-4 py-2">{{ number_format($file->file_size / 1024, 2) }} KB</td>
                            {{-- <td class="border px-4 py-2">{{ $file->description ?? '-' }}</td> --}}
                            <td class="border px-4 py-2">{{ $file->updated_at->format('Y-m-d H:i') ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $file->updated_user_name ?? '-' }}</td>
                            <td class="border px-4 py-2 flex gap-2 justify-center">
                                <a href="{{ route('admin.files.preview', ['type' => $type, 'id' => $file->id]) }}"
                                    target="_blank" rel="noopener"
                                    class="save bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 hover:text-white">
                                    プレビュー
                                </a>

                                <a href="{{ route('admin.files.edit', ['type' => $type, 'id' => $file->id]) }}"
                                    class="save text-white px-2 py-1 rounded hover:bg-yellow-600">編集</a>
                                <form method="POST"
                                    action="{{ route('admin.files.destroy', ['type' => $type, 'id' => $file->id]) }}"
                                    onsubmit="return confirm('削除してよろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="delete bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                        削除
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- ページネーション（下） --}}
        <div class="mt-4">
            {{ $files->appends(request()->query())->links() }}
        </div>
    </div>

@endsection
