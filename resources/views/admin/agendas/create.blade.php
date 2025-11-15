@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">アジェンダ作成</h1>

    <form action="{{ route('admin.agendas.store') }}" method="POST">
        @csrf

        {{-- アジェンダ名 --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">アジェンダ名</label>
            <input type="text" name="agenda_name" value="{{ old('agenda_name') }}" class="border px-2 py-1 w-full rounded" required>
        </div>

        {{-- カテゴリ --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">カテゴリID</label>
            <input type="number" name="category_id" value="{{ old('category_id') }}" class="border px-2 py-1 w-full rounded">
        </div>

        {{-- 内容・概要 (CKEditor) --}}
        <div class="not-prose">

            <div class="mb-4">
                <label class="block font-medium mb-1">内容・概要</label>
                <textarea name="description" id="description" class="ckeditor border px-2 py-1 w-full rounded">{{ old('description') }}</textarea>
            </div>
        </div>

        {{-- 表示フラグ --}}
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_show" value="1" {{ old('is_show') ? 'checked' : '' }} class="mr-2">
                表示する
            </label>
        </div>

        {{-- 承認 --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">承認状態</label>
            <select name="accept" class="border px-2 py-1 w-full rounded" required>
                <option value="draft" {{ old('accept') == 'draft' ? 'selected' : '' }}>下書き</option>
                <option value="承認済み" {{ old('accept') == '承認済み' ? 'selected' : '' }}>承認済み</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
    </form>
</div>
@endsection
