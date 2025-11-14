@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Level詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>code:</strong> {{ $Level->code }}</p>
            <p><strong>name:</strong> {{ $Level->name }}</p>

        </div>
        <a href="{{ route('admin.levels.edit', $Level->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('admin.levels.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection
