@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 pb-24">
    <h1 class="text-2xl font-bold mb-6">{{ isset($agenda) ? 'アジェンダ編集' : 'アジェンダ作成' }}</h1>

    <form action="{{ isset($agenda) ? route('admin.agendas.update', $agenda->id) : route('admin.agendas.store') }}" method="POST">
        @csrf
        @if(isset($agenda)) @method('PUT') @endif

        <div class="mb-4">
            <label class="block font-medium mb-1">アジェンダ名</label>
            <input type="text" name="agenda_name" value="{{ old('agenda_name', $agenda->agenda_name ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Description</label>
            <textarea id="description" name="description" class="border px-2 py-1 w-full rounded">{{ old('description', $agenda->description ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_show" value="1" {{ old('is_show', $agenda->is_show ?? 1) ? 'checked' : '' }}>
                <span class="ml-2">表示する</span>
            </label>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Accept</label>
            <select name="accept" class="border px-2 py-1 w-full rounded">
                <option value="yes" {{ old('accept', $agenda->accept ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ old('accept', $agenda->accept ?? '') == 'no' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ isset($agenda) ? '更新' : '保存' }}</button>
    </form>
</div>

<script src="https://cdn.ckeditor.com/4.25.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description', {
        height: 300,
        allowedContent: true, // 生HTMLも許可
    });
</script>
@endsection
