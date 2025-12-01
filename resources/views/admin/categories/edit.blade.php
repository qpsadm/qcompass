@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-xl bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">カテゴリー編集</h1>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- コード --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">コード</label>
                <input type="text" name="code" value="{{ old('code', $category->code) }}" required
                    class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- カテゴリー名 --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">カテゴリー名</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 親カテゴリ --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">親カテゴリ</label>
                <select name="parent_id"
                    class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">（なし）</option>
                    @foreach ($categories as $c)
                        @if ($c->id !== $category->id)
                            <option value="{{ $c->id }}"
                                {{ old('parent_id', $category->parent_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}（ID: {{ $c->id }}）
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- 表示フラグ --}}
     <div class="mb-4" x-data="{ is_show: {{ old('is_show', $category->is_show ?? 0) }} }">
    <span class="font-medium mr-2">表示フラグ</span>
    <div class="flex gap-2">
        <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
            <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
            公開
        </label>

        <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
            <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
            非公開
        </label>
    </div>
</div>

            {{-- ボタン群 --}}
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded shadow-sm">
                    更新
                </button>
                <a href="{{ route('admin.categories.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow-sm">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
@endsection
