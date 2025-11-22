@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md max-w-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">講座種類編集</h1>

    <form action="{{ route('admin.levels.update', $Level->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf
        @method('PUT')

        {{-- レベルコード --}}
        <div>
            <label for="code" class="block text-gray-700 font-semibold mb-2">レベルコード</label>
            <input type="text" name="code" id="code" value="{{ old('code', $Level->code ?? '') }}"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- 種類 --}}
        <div>
            <label for="name" class="block text-gray-700 font-semibold mb-2">種類</label>
            <input type="text" name="name" id="name" value="{{ old('name', $Level->name ?? '') }}"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- 表示/非表示 --}}
        <div class="flex items-center gap-2 mt-2">
            <input type="hidden" name="is_show" value="0"> {{-- 未チェック対策 --}}
            <input type="checkbox" id="is_show" name="is_show" value="1"
                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                {{ old('is_show', $Level->is_show) == 1 ? 'checked' : '' }}>

            <label for="is_show" class="text-gray-700 font-semibold">
                表示する
            </label>
        </div>


        {{-- ボタン --}}
        <div class="flex justify-between gap-2 mt-4">
            <button type="submit"
                class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded shadow-sm transition">
                更新
            </button>
            <a href="{{ route('admin.levels.index') }}"
                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded shadow-sm text-center transition">
                一覧に戻る
            </a>
        </div>
    </form>
</div>
@endsection
