@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">アジェンダファイル詳細</h1>

        <table class="table-auto w-full border-collapse mb-6">
            <tbody>
                <tr>
                    <td class="border px-4 py-2 font-bold">アジェンダ</td>
                    <td class="border px-4 py-2">{{ $agendaFile->agenda?->agenda_name ?? '未設定' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">ファイル名</td>
                    <td class="border px-4 py-2">{{ $agendaFile->file_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">ファイルタイプ</td>
                    <td class="border px-4 py-2">{{ $agendaFile->file_type ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">説明</td>
                    <td class="border px-4 py-2">{{ $agendaFile->description ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">ファイルリンク</td>
                    <td class="border px-4 py-2">
                        @if ($agendaFile->file_path)
                            <a href="{{ route('admin.agenda_files.download', $agendaFile->id) }}"
                                class="text-blue-500 underline" target="_blank">ダウンロード</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- プレビュー --}}
        @if ($agendaFile->file_path)
            <div class="mb-6">
                @if (str_starts_with($agendaFile->file_type, 'image'))
                    <img src="{{ route('admin.agenda_files.preview', $agendaFile->id) }}" alt="画像プレビュー"
                        class="max-w-full border rounded shadow-sm">
                @elseif ($agendaFile->file_type === 'application/pdf')
                    <iframe src="{{ route('admin.agenda_files.preview', $agendaFile->id) }}" width="100%" height="600px"
                        class="border rounded shadow-sm"></iframe>
                @else
                    <p class="text-gray-500">このファイルはブラウザでプレビューできません。</p>
                @endif
            </div>
        @endif

        <div class="flex gap-2 mt-4">
            <a href="{{ route('admin.agenda_files.edit', $agendaFile->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('admin.agenda_files.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">一覧に戻る</a>
        </div>
    </div>
@endsection
