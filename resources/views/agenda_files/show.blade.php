@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">AgendaFile詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>agenda_id:</strong> {{ $AgendaFile->agenda_id }}</p>
<p><strong>file_path:</strong> {{ $AgendaFile->file_path }}</p>
<p><strong>file_name:</strong> {{ $AgendaFile->file_name }}</p>
<p><strong>file_type:</strong> {{ $AgendaFile->file_type }}</p>
<p><strong>description:</strong> {{ $AgendaFile->description }}</p>
<p><strong>file_size:</strong> {{ $AgendaFile->file_size }}</p>
<p><strong>user_id:</strong> {{ $AgendaFile->user_id }}</p>
<p><strong>deleted_at:</strong> {{ $AgendaFile->deleted_at }}</p>

    </div>
    <a href="{{ route('agenda_files.edit', $AgendaFile->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('agenda_files.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection