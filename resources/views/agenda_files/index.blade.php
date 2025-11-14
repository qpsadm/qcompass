@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">AgendaFile一覧</h1>
    <a href="{{ route('agenda_files.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>agenda_id</th>
<th class='border px-4 py-2'>file_path</th>
<th class='border px-4 py-2'>file_name</th>
<th class='border px-4 py-2'>file_type</th>
<th class='border px-4 py-2'>description</th>
<th class='border px-4 py-2'>file_size</th>
<th class='border px-4 py-2'>user_id</th>
<th class='border px-4 py-2'>deleted_at</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agenda_files as $AgendaFile)
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
                    <a href="{{ route('agenda_files.show', $AgendaFile->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('agenda_files.edit', $AgendaFile->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('agenda_files.destroy', $AgendaFile->id) }}" method="POST" class="inline-block ml-2">
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