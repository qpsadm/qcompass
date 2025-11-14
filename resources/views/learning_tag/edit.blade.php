@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">LearningTag編集</h1>
    <form action="{{ route('learning_tag.update', $LearningTag->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
    <label class="block font-medium mb-1">learning_id</label>
    <input type="text" name="learning_id" value="{{ old('learning_id', $LearningTag->learning_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">tag_id</label>
    <input type="text" name="tag_id" value="{{ old('tag_id', $LearningTag->tag_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_at</label>
    <input type="text" name="deleted_at" value="{{ old('deleted_at', $LearningTag->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
    </form>
</div>
@endsection