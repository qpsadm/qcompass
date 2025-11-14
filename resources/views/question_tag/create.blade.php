@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">QuestionTag作成</h1>
    <form action="{{ route('question_tag.store') }}" method="POST">
        @csrf
        <div class="mb-4">
    <label class="block font-medium mb-1">question_id</label>
    <input type="text" name="question_id" value="{{ old('question_id', $QuestionTag->question_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">tag_id</label>
    <input type="text" name="tag_id" value="{{ old('tag_id', $QuestionTag->tag_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_at</label>
    <input type="text" name="deleted_at" value="{{ old('deleted_at', $QuestionTag->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
    </form>
</div>
@endsection