@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 pb-24 max-w-md">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 text-center">講座種類作成</h1>

        <form action="{{ route('admin.levels.store') }}" method="POST" class="bg-white p-8 rounded-xl shadow-lg space-y-6">
            @csrf

            {{-- レベルコード --}}
            <div>
                <label for="code" class="block text-gray-700 font-medium mb-2">レベルコード</label>
                <input type="text" name="code" id="code" value="{{ old('code') }}" placeholder="例: L01"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                @error('code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 難易度 --}}
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-2">種類</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ボタン --}}
            <div class="flex justify-between gap-4 mt-6">
                <button type="submit"
                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200">
                    保存
                </button>
                <a href="{{ route('admin.levels.index') }}"
                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200 text-center">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
@endsection
