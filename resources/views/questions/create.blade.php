@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Question作成</h1>
    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <div class="mb-4">
    <label class="block font-medium mb-1">asker_id</label>
    <input type="text" name="asker_id" value="{{ old('asker_id', $Question->asker_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">agenda_id</label>
    <input type="text" name="agenda_id" value="{{ old('agenda_id', $Question->agenda_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">course_id</label>
    <input type="text" name="course_id" value="{{ old('course_id', $Question->course_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">title</label>
    <input type="text" name="title" value="{{ old('title', $Question->title ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">responder_id</label>
    <input type="text" name="responder_id" value="{{ old('responder_id', $Question->responder_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">content</label>
    <input type="text" name="content" value="{{ old('content', $Question->content ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">answer</label>
    <input type="text" name="answer" value="{{ old('answer', $Question->answer ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">is_show</label>
    <input type="text" name="is_show" value="{{ old('is_show', $Question->is_show ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_at</label>
    <input type="text" name="deleted_at" value="{{ old('deleted_at', $Question->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
    </form>
</div>
@endsection