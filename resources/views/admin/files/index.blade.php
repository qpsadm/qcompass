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

        {{-- 新規作成ボタンは targetId がある場合のみ --}}
        @if (!empty($targetId))
            <div class="mb-4">
                <a href="{{ route('admin.files.create', ['type' => $type, 'targetId' => $targetId]) }}"
                    class="new bg-yellow-400 border border-gray-200 text-black px-4 py-2 rounded hover:bg-blue-600">
                    新規作成
                </a>
            </div>
        @endif

        @if ($files->isEmpty())
            <p>ファイルはまだ登録されていません。</p>
        @else
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 w-20">No.</th>
                        <th class="border px-4 py-2 w-60">ファイル名</th>
                        <th class="border px-4 py-2 w-32">種類</th>
                        <th class="border px-4 py-2 w-32">サイズ</th>
                        {{-- <th class="border px-4 py-2 w-40">説明</th> --}}
                        <th class="border px-4 py-2 w-40">作成日</th>
                        <th class="border px-4 py-2 w-32">作成者</th>
                        <th class="border px-4 py-2 w-48">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $file->file_name }}</td>
                            <td class="border px-4 py-2">{{ $file->file_type }}</td>
                            <td class="border px-4 py-2">{{ number_format($file->file_size / 1024, 2) }} KB</td>
                            {{-- <td class="border px-4 py-2">{{ $file->description ?? '-' }}</td> --}}
                            <td class="border px-4 py-2">{{ $file->updated_at->format('Y-m-d H:i') ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $file->created_user_name ?? '-' }}</td>
                            <td class="border px-4 py-2 flex gap-2 justify-center">
                                <a href="{{ route('admin.files.preview', ['type' => $type, 'id' => $file->id]) }}"
                                    target="_blank" rel="noopener"
                                    class="save bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                                    プレビュー
                                </a>

                                <a href="{{ route('admin.files.edit', ['type' => $type, 'id' => $file->id]) }}"
                                    class="save bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">編集</a>
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
    </div>
@endsection
