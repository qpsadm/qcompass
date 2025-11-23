@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-bold mb-4">お知らせ分類 編集</h1>

    <form method="POST" action="{{ route('admin.announcement_types.update', $type->id) }}">
        @csrf
        @method('PUT')

        @include('admin.announcement_types.form', ['type' => $type])

        <button class="bg-blue-600 text-white px-4 py-2 rounded">更新</button>
        <a href="{{ route('admin.announcement_types.index') }}"
            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
            一覧に戻る
        </a>
    </form>
</div>
@endsection
