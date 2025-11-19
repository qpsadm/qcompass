@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">質問編集</h1>
            <form action="{{ route('questions.update', $Question->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block font-medium mb-1">質問者ID</label>
                    <input type="text" name="asker_id" value="{{ old('asker_id', $Question->asker_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">関連アジェンダID</label>
                    <input type="text" name="agenda_id" value="{{ old('agenda_id', $Question->agenda_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">講座ID</label>
                    <input type="text" name="course_id" value="{{ old('course_id', $Question->course_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">質問タイトル</label>
                    <input type="text" name="title" value="{{ old('title', $Question->title ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">回答講師ID</label>
                    <input type="text" name="responder_id"
                        value="{{ old('responder_id', $Question->responder_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">質問内容</label>
                    <input type="text" name="content" value="{{ old('content', $Question->content ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">回答内容</label>
                    <input type="text" name="answer" value="{{ old('answer', $Question->answer ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">公開/非公開</label>
                    <input type="text" name="is_show" value="{{ old('is_show', $Question->is_show ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">削除日</label>
                    <input type="text" name="deleted_at" value="{{ old('deleted_at', $Question->deleted_at ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
            </form>
        </div>
    @endsection
