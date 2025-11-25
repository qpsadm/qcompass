@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-6xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">アジェンダファイル一覧</h1>

            <div class="mb-4">
                <a href="{{ route('admin.agenda_files.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow-sm transition">
                    新規作成
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left">アジェンダID</th>
                            <th class="border px-4 py-2 text-left">ファイル名</th>
                            <th class="border px-4 py-2 text-left">ファイルパス</th>
                            <th class="border px-4 py-2 text-left">ファイルサイズ</th>
                            <th class="border px-4 py-2 text-left">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agenda_files as $AgendaFile)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $AgendaFile->agenda_id }}</td>
                                <td class="border px-4 py-2">{{ $AgendaFile->file_name }}</td>
                                <td class="border px-4 py-2">{{ $AgendaFile->file_path }}</td>
                                <td class="border px-4 py-2">{{ $AgendaFile->file_size }}</td>
                                <td class="border px-4 py-2 space-x-2">
                                    <a href="{{ route('admin.agenda_files.show', $AgendaFile->id) }}"
                                        class="text-green-600 hover:underline">詳細</a>
                                    <a href="{{ route('admin.agenda_files.edit', $AgendaFile->id) }}"
                                        class="text-blue-600 hover:underline">編集</a>
                                    <form action="{{ route('admin.agenda_files.destroy', $AgendaFile->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
