@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">アジェンダタグ編集</h1>
            <form action="{{ route('agenda_tag.update', $AgendaTag->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block font-medium mb-1">アジェンダID</label>
                    <input type="text" name="target_id" value="{{ old('target_id', $AgendaTag->target_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">タグID</label>
                    <input type="text" name="tag_id" value="{{ old('tag_id', $AgendaTag->tag_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">削除日</label>
                    <input type="text" name="deleted_at" value="{{ old('deleted_at', $AgendaTag->deleted_at ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
            </form>
        </div>
    @endsection
