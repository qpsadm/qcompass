@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">QuestionChoice編集</h1>
    <form action="{{ route('question_choices.update', $QuestionChoice->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
    <label class="block font-medium mb-1">question_id</label>
    <input type="text" name="question_id" value="{{ old('question_id', $QuestionChoice->question_id ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">choice_text</label>
    <input type="text" name="choice_text" value="{{ old('choice_text', $QuestionChoice->choice_text ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">is_correct</label>
    <input type="text" name="is_correct" value="{{ old('is_correct', $QuestionChoice->is_correct ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>
<div class="mb-4">
    <label class="block font-medium mb-1">order</label>
    <input type="text" name="order" value="{{ old('order', $QuestionChoice->order ?? '') }}" class="border px-2 py-1 w-full rounded">
</div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
    </form>
</div>
@endsection