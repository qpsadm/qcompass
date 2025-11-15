@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">カテゴリー編集</h1>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- コード -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">コード</label>
            <input type="text" name="code" value="{{ old('code', $category->code) }}" required
                class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('code')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- カテゴリー名 -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">カテゴリー名</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 親カテゴリ -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">親カテゴリ</label>
            <select name="parent_id"
                class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">（なし）</option>
                @foreach($categories as $c)
                @if($c->id !== $category->id) <!-- 自分自身は選べない -->
                <option value="{{ $c->id }}" {{ old('parent_id', $category->parent_id) == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}（ID: {{ $c->id }}）
                </option>
                @endif
                @endforeach
            </select>
        </div>

        <!-- トップカテゴリ -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">トップカテゴリ</label>
            <select name="top_id"
                class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">（なし）</option>
                @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ old('top_id', $category->top_id) == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}（ID: {{ $c->id }}）
                </option>
                @endforeach
            </select>
        </div>

        <!-- 階層 -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">階層</label>
            <input type="number" name="level" value="{{ old('level', $category->level) }}"
                class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- 子数 -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">子数</label>
            <input type="number" name="child_count" value="{{ old('child_count', $category->child_count) }}"
                class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- 表示フラグ -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">表示フラグ</label>
            <select name="is_show"
                class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="1" {{ old('is_show', $category->is_show) == 1 ? 'selected' : '' }}>表示</option>
                <option value="0" {{ old('is_show', $category->is_show) == 0 ? 'selected' : '' }}>非表示</option>
            </select>
        </div>

        <!-- テーマカラー -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">テーマカラー</label>
            <select name="theme_color"
                class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="blue" {{ old('theme_color', $category->theme_color) == 'blue' ? 'selected' : '' }}>青</option>
            </select>
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded shadow-sm">
            更新
        </button>
        <a href="{{ route('admin.categories.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow-sm ml-2">
            一覧に戻る
        </a>
    </form>
</div>
@endsection
