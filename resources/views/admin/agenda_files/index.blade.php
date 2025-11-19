@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">

        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
            <h1 class="text-2xl font-bold mb-4">アジェンダファイル一覧</h1>
            <a href="{{ route('admin.agenda_files.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

            <table class="table-auto border-collapse border w-full">
                <thead>
                    <tr>
                        <th class='border px-4 py-2'>アジェンダID</th>
                        <th class='border px-4 py-2'>ファイルパス</th>
                        <th class='border px-4 py-2'>ファイル名</th>
                        <th class='border px-4 py-2'>ファイルタイプ</th>
                        <th class='border px-4 py-2'>用途・備考</th>
                        <th class='border px-4 py-2'>ファイルサイズ</th>
                        <th class='border px-4 py-2'>ユーザーID</th>
                        <th class='border px-4 py-2'>削除日</th>
                        <th class='border px-4 py-2'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agenda_files as $AgendaFile)
                        <tr>
                            <td class='border px-4 py-2'>{{ $AgendaFile->agenda_id }}</td>
                            <td class='border px-4 py-2'>{{ $AgendaFile->file_path }}</td>
                            <td class='border px-4 py-2'>{{ $AgendaFile->file_name }}</td>
                            <td class='border px-4 py-2'>{{ $AgendaFile->file_type }}</td>
                            <td class='border px-4 py-2'>{{ $AgendaFile->description }}</td>
                            <td class='border px-4 py-2'>{{ $AgendaFile->file_size }}</td>
                            <td class='border px-4 py-2'>{{ $AgendaFile->user_id }}</td>
                            <td class='border px-4 py-2'>{{ $AgendaFile->deleted_at }}</td>
                            <td class='border px-4 py-2'>
                                <a href="{{ route('admin.agenda_files.show', $AgendaFile->id) }}"
                                    class="text-green-600">詳細</a>
                                <a href="{{ route('admin.agenda_files.edit', $AgendaFile->id) }}"
                                    class="text-blue-600 ml-2">編集</a>
                                <form action="{{ route('admin.agenda_files.destroy', $AgendaFile->id) }}" method="POST"
                                    class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
