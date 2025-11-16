@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">アジェンダ編集</h1>

    <form action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- アジェンダ名 --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">アジェンダ名</label>
            <input type="text" name="agenda_name"
                value="{{ old('agenda_name', $agenda->agenda_name) }}"
                class="border px-2 py-1 w-full rounded" required>
        </div>

        {{-- カテゴリ --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">カテゴリ</label>
            <select name="category_id" class="border px-2 py-1 w-full rounded">
                <option value="">選択してください</option>
                @foreach ($categories as $cat)
                <option value="{{ $cat['id'] }}"
                    {{ old('category_id', $agenda->category_id ?? '') == $cat['id'] ? 'selected' : '' }}>
                    {{ $cat['name'] }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- 表示フラグ --}}
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_show" value="1"
                    {{ old('is_show', $agenda->is_show) ? 'checked' : '' }} class="mr-2">
                表示する
            </label>
        </div>

        {{-- 承認 --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">承認状態</label>
            <select name="accept" class="border px-2 py-1 w-full rounded" required>
                <option value="yes" {{ old('accept', $agenda->accept) == 'yes' ? 'selected' : '' }}>承認済み</option>
                <option value="no" {{ old('accept', $agenda->accept) == 'no' ? 'selected' : '' }}>下書き</option>
            </select>
        </div>

        {{-- 内容・概要 (CKEditor) --}}
        <div class="mb-4">
            <label for="description" class="block font-medium mb-1">内容・概要</label>
            <textarea name="description" id="description" class="border px-2 py-1 w-full rounded">
            {{ old('description', $agenda->description ?? '') }}
            </textarea>
        </div>


        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新</button>
    </form>
</div>

{{-- CKEditor 4 CDN を読み込む --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    // CKEditor 4 の初期化
    CKEDITOR.replace('description', {
        language: 'ja',
        allowedContent: true, // すべてのタグ・属性・スタイルを許可
    });
</script>
@endsection
