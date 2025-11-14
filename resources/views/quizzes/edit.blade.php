@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Quiz編集</h1>
    <form action="{{ route('quizzes.update', $Quiz->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
    <label class="block font-medium mb-1">code</label>
    <input type="text" name="code" value="{{ old('code', $Quiz->code ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">title</label>
    <input type="text" name="title" value="{{ old('title', $Quiz->title ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">description</label>
    <input type="text" name="description" value="{{ old('description', $Quiz->description ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">course_id</label>
    <input type="text" name="course_id" value="{{ old('course_id', $Quiz->course_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">agenda_id</label>
    <input type="text" name="agenda_id" value="{{ old('agenda_id', $Quiz->agenda_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">type</label>
    <input type="text" name="type" value="{{ old('type', $Quiz->type ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">time_limit</label>
    <input type="text" name="time_limit" value="{{ old('time_limit', $Quiz->time_limit ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">total_score</label>
    <input type="text" name="total_score" value="{{ old('total_score', $Quiz->total_score ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">passing_score</label>
    <input type="text" name="passing_score" value="{{ old('passing_score', $Quiz->passing_score ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">random_order</label>
    <input type="text" name="random_order" value="{{ old('random_order', $Quiz->random_order ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">active_from</label>
    <input type="text" name="active_from" value="{{ old('active_from', $Quiz->active_from ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">active_to</label>
    <input type="text" name="active_to" value="{{ old('active_to', $Quiz->active_to ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">created_by</label>
    <input type="text" name="created_by" value="{{ old('created_by', $Quiz->created_by ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">deleted_at</label>
    <input type="text" name="deleted_at" value="{{ old('deleted_at', $Quiz->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
    </form>
</div>
@endsection