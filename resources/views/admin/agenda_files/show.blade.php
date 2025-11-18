@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-lg">
        <h1 class="text-2xl font-bold mb-6">アジェンダファイル詳細</h1>

        <table class="table-auto w-full border-collapse">
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
                            <a href="{{ asset('storage/' . $agendaFile->file_path) }}" class="text-blue-500 underline"
                                target="_blank">ダウンロード</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex gap-2 mt-4">
            <a href="{{ route('admin.agenda_files.edit', $agendaFile->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('admin.agenda_files.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">一覧に戻る</a>
        </div>
    </div>
@endsection
