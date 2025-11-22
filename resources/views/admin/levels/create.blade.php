@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md max-w-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">講座種類作成</h1>

    <form action="{{ route('admin.levels.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf

        {{-- レベルコード --}}
        <div>
            <label for="code" class="block text-gray-700 font-semibold mb-2">レベルコード</label>
            <input type="text" name="code" id="code" value="{{ old('code') }}" required placeholder="例: L01"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('code')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- 種類名 --}}
        <div>
            <label for="name" class="block text-gray-700 font-semibold mb-2">種類名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- 表示フラグ --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">表示/非表示</label>
            <select name="is_show" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="1" {{ old('is_show') == '1' ? 'selected' : '' }}>表示</option>
                <option value="0" {{ old('is_show') == '0' ? 'selected' : '' }}>非表示</option>
            </select>
        </div>

        {{-- ボタン --}}
        <div class="flex justify-between gap-2 mt-4">
            <button type="submit"
                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded shadow-sm transition">
                保存
            </button>
            <a href="{{ route('admin.levels.index') }}"
                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded shadow-sm text-center transition">
                一覧に戻る
            </a>
        </div>
    </form>
</div>
@endsection
