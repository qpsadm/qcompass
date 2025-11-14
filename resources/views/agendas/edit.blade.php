@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Agenda編集</h1>
    <form action="{{ route('agendas.update', $Agenda->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
    <label class="block font-medium mb-1">agenda_name</label>
    <input type="text" name="agenda_name" value="{{ old('agenda_name', $Agenda->agenda_name ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">category_id</label>
    <input type="text" name="category_id" value="{{ old('category_id', $Agenda->category_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">description</label>
    <input type="text" name="description" value="{{ old('description', $Agenda->description ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">is_show</label>
    <input type="text" name="is_show" value="{{ old('is_show', $Agenda->is_show ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">user_id</label>
    <input type="text" name="user_id" value="{{ old('user_id', $Agenda->user_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">accept</label>
    <input type="text" name="accept" value="{{ old('accept', $Agenda->accept ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">created_user_id</label>
    <input type="text" name="created_user_id" value="{{ old('created_user_id', $Agenda->created_user_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">updated_user_id</label>
    <input type="text" name="updated_user_id" value="{{ old('updated_user_id', $Agenda->updated_user_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_at</label>
    <input type="text" name="deleted_at" value="{{ old('deleted_at', $Agenda->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_user_id</label>
    <input type="text" name="deleted_user_id" value="{{ old('deleted_user_id', $Agenda->deleted_user_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
    </form>
</div>
@endsection