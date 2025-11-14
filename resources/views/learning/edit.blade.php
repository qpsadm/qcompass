@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Learning編集</h1>
    <form action="{{ route('learning.update', $Learning->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
    <label class="block font-medium mb-1">type</label>
    <input type="text" name="type" value="{{ old('type', $Learning->type ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">name</label>
    <input type="text" name="name" value="{{ old('name', $Learning->name ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">author</label>
    <input type="text" name="author" value="{{ old('author', $Learning->author ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">publisher</label>
    <input type="text" name="publisher" value="{{ old('publisher', $Learning->publisher ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">publication_date</label>
    <input type="text" name="publication_date" value="{{ old('publication_date', $Learning->publication_date ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">isbn</label>
    <input type="text" name="isbn" value="{{ old('isbn', $Learning->isbn ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">url</label>
    <input type="text" name="url" value="{{ old('url', $Learning->url ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">image</label>
    <input type="text" name="image" value="{{ old('image', $Learning->image ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">level</label>
    <input type="text" name="level" value="{{ old('level', $Learning->level ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">description</label>
    <input type="text" name="description" value="{{ old('description', $Learning->description ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_at</label>
    <input type="text" name="deleted_at" value="{{ old('deleted_at', $Learning->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
    </form>
</div>
@endsection