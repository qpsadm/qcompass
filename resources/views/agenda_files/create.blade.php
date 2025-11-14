@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">AgendaFile作成</h1>
    <form action="{{ route('agenda_files.store') }}" method="POST">
        @csrf
        <div class="mb-4">
    <label class="block font-medium mb-1">agenda_id</label>
    <input type="text" name="agenda_id" value="{{ old('agenda_id', $AgendaFile->agenda_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">file_path</label>
    <input type="text" name="file_path" value="{{ old('file_path', $AgendaFile->file_path ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">file_name</label>
    <input type="text" name="file_name" value="{{ old('file_name', $AgendaFile->file_name ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">file_type</label>
    <input type="text" name="file_type" value="{{ old('file_type', $AgendaFile->file_type ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">description</label>
    <input type="text" name="description" value="{{ old('description', $AgendaFile->description ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">file_size</label>
    <input type="text" name="file_size" value="{{ old('file_size', $AgendaFile->file_size ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">user_id</label>
    <input type="text" name="user_id" value="{{ old('user_id', $AgendaFile->user_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_at</label>
    <input type="text" name="deleted_at" value="{{ old('deleted_at', $AgendaFile->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
    </form>
</div>
@endsection