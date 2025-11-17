@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-lg">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">講座種類詳細</h1>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <p class="mb-2"><span class="font-semibold">レベルコード:</span> {{ $Level->code }}</p>
            <p><span class="font-semibold">難易度:</span> {{ $Level->name }}</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.levels.edit', $Level->id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                編集
            </a>
            <a href="{{ route('admin.levels.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                一覧に戻る
            </a>
        </div>
    </div>
@endsection
