@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">        <h1 class="text-2xl font-bold mb-4">アジェンダタグ作成</h1>
        <form action="{{ route('agenda_tag.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-medium mb-1">アジェンダID</label>
                <input type="text" name="agenda_id" value="{{ old('agenda_id', $AgendaTag->agenda_id ?? '') }}"
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

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
        </form>
    </div>
@endsection
