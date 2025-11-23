@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-bold mb-4">お知らせ分類 作成</h1>

    <form method="POST" action="{{ route('admin.announcement_types.store') }}">
        @csrf

        @include('admin.announcement_types.form')

        <div class="flex items-center space-x-2 mt-4">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                作成
            </button>

            <a href="{{ route('admin.announcement_types.index') }}"
                class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                一覧に戻る
            </a>
        </div>
    </form>
</div>
@endsection
