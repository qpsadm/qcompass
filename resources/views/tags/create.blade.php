@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tag作成</h1>
    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="mb-4">
    <label class="block font-medium mb-1">code</label>
    <input type="text" name="code" value="{{ old('code', $Tag->code ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">name</label>
    <input type="text" name="name" value="{{ old('name', $Tag->name ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">tag_type</label>
    <input type="text" name="tag_type" value="{{ old('tag_type', $Tag->tag_type ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">theme_color</label>
    <input type="text" name="theme_color" value="{{ old('theme_color', $Tag->theme_color ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">description</label>
    <input type="text" name="description" value="{{ old('description', $Tag->description ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_at</label>
    <input type="text" name="deleted_at" value="{{ old('deleted_at', $Tag->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
    </form>
</div>
@endsection