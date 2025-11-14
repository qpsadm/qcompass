@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Achievement編集</h1>
    <form action="{{ route('achievements.update', $Achievement->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
    <label class="block font-medium mb-1">title</label>
    <input type="text" name="title" value="{{ old('title', $Achievement->title ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">description</label>
    <input type="text" name="description" value="{{ old('description', $Achievement->description ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">condition_type</label>
    <input type="text" name="condition_type" value="{{ old('condition_type', $Achievement->condition_type ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">condition_value</label>
    <input type="text" name="condition_value" value="{{ old('condition_value', $Achievement->condition_value ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_at</label>
    <input type="text" name="deleted_at" value="{{ old('deleted_at', $Achievement->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
    </form>
</div>
@endsection