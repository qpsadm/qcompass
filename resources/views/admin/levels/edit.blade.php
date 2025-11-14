@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">講座種類編集</h1>

    <form action="{{ route('admin.levels.update', $Level->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="code" class="block text-gray-700 font-semibold mb-2">code</label>
            <input type="text" name="code" id="code"
                value="{{ old('code', $Level->code ?? '') }}"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="name" class="block text-gray-700 font-semibold mb-2">name</label>
            <input type="text" name="name" id="name"
                value="{{ old('name', $Level->name ?? '') }}"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="flex gap-2 mt-4">
            <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                更新
            </button>
            <a href="{{ route('admin.levels.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                一覧に戻る
            </a>
        </div>
    </form>
</div>
@endsection
