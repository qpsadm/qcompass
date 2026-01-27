{{-- resources/views/admin/files/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    @php
    // タイプごとの日本語タイトル
    $titles = [
    'agenda' => 'アジェンダ',
    'announcement' => 'お知らせ',
    ];
    $japaneseTitle = $titles[$type] ?? 'ファイル';
    @endphp

    <h1 class="text-2xl font-bold mb-4">{{ $japaneseTitle }} ファイル一覧</h1>

    {{-- 新規作成ボタンは targetId がある場合のみ --}}
    @if(!empty($targetId))
    <div class="mb-4">
        <a href="{{ route('admin.files.create', ['type' => $type, 'targetId' => $targetId]) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            新規作成
        </a>
    </div>
    @endif

    @if($files->isEmpty())
    <p>ファイルはまだ登録されていません。</p>
    @else
    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ファイル名</th>
                <th class="border px-4 py-2">種類</th>
                <th class="border px-4 py-2">サイズ</th>
                <th class="border px-4 py-2">説明</th>
                <th class="border px-4 py-2">作成者</th>
                <th class="border px-4 py-2">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
            <tr>
                <td class="border px-4 py-2">{{ $file->file_name }}</td>
                <td class="border px-4 py-2">{{ $file->file_type }}</td>
                <td class="border px-4 py-2">{{ number_format($file->file_size / 1024, 2) }} KB</td>
                <td class="border px-4 py-2">{{ $file->description ?? '-' }}</td>
                <td class="border px-4 py-2">{{ $file->created_user_name ?? '-' }}</td>
                <td class="border px-4 py-2 flex gap-2">
                    <a href="{{ route('admin.files.preview', ['type' => $type, 'id' => $file->id]) }}"
                        target="_blank"
                        rel="noopener"
                        class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                        プレビュー
                    </a>
                    <a href="{{ route('admin.files.edit', ['type' => $type, 'id' => $file->id]) }}"
                        class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">編集</a>
                    <form method="POST"
                        action="{{ route('admin.files.destroy', ['type' => $type, 'id' => $file->id]) }}"
                        onsubmit="return confirm('削除してよろしいですか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                            削除
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
