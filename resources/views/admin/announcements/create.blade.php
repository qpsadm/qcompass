@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-bold mb-4">お知らせ 新規作成</h1>

    <form method="POST" action="{{ route('admin.announcements.store') }}">
        @csrf

        @include('admin.announcements.form')

        <button class="bg-blue-600 text-white px-4 py-2 rounded">作成</button>
        <a href="{{ route('admin.announcements.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
            一覧に戻る
        </a>
    </form>
</div>
@endsection
