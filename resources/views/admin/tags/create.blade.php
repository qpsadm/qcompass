@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">タグ作成</h1>

    <form action="{{ route('admin.tags.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- タグコード --}}
        <div>
            <label class="block font-medium mb-1">タグコード</label>
            <input type="text" name="code" value="{{ old('code', $Tag->code ?? '') }}"
                class="border px-3 py-2 w-full rounded" placeholder="任意">
        </div>

        {{-- タグ名 --}}
        <div>
            <label class="block font-medium mb-1">タグ名 <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $Tag->name ?? '') }}"
                class="border px-3 py-2 w-full rounded" placeholder="必須">
        </div>

        {{-- タグ用途分類 --}}
        <div>
            <label class="block font-medium mb-1">タグの用途分類</label>
            <select name="tag_type" class="border px-3 py-2 w-full rounded">
                <option value="">選択してください</option>
                @foreach(['agenda','course','book','resume','job','qualification','learning_site','custom'] as $type)
                <option value="{{ $type }}" {{ (old('tag_type', $Tag->tag_type ?? '') === $type) ? 'selected' : '' }}>
                    {{ $type }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- テーマカラー --}}
        <div>
            <label class="block font-medium mb-1">テーマカラー</label>
            <select name="theme_color" class="border px-3 py-2 w-full rounded">
                <option value="">選択してください</option>
                <option value="blue" {{ (old('theme_color', $Tag->theme_color ?? '') === 'blue') ? 'selected' : '' }}>青</option>
            </select>
        </div>

        {{-- 説明 --}}
        <div>
            <label class="block font-medium mb-1">説明</label>
            <textarea name="description" class="border px-3 py-2 w-full rounded" placeholder="タグの説明">{{ old('description', $Tag->description ?? '') }}</textarea>
        </div>

        {{-- 保存ボタン --}}
<div class="flex gap-2">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
        保存
    </button>

    <a href="{{ route('admin.tags.index') }}"
       class="px-3 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
        一覧に戻る
    </a>
</div>
    </form>
</div>
@endsection
