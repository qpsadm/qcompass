@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Category作成</h1>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
    <label class="block font-medium mb-1">code</label>
    <input type="text" name="code" value="{{ old('code', $Category->code ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">name</label>
    <input type="text" name="name" value="{{ old('name', $Category->name ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">parent_id</label>
    <input type="text" name="parent_id" value="{{ old('parent_id', $Category->parent_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">top_id</label>
    <input type="text" name="top_id" value="{{ old('top_id', $Category->top_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">level</label>
    <input type="text" name="level" value="{{ old('level', $Category->level ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">child_count</label>
    <input type="text" name="child_count" value="{{ old('child_count', $Category->child_count ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">is_show</label>
    <input type="text" name="is_show" value="{{ old('is_show', $Category->is_show ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">theme_color</label>
    <input type="text" name="theme_color" value="{{ old('theme_color', $Category->theme_color ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_at</label>
    <input type="text" name="deleted_at" value="{{ old('deleted_at', $Category->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
    </form>
</div>
@endsection
