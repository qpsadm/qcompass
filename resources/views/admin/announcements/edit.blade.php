@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-bold mb-4">お知らせ 編集</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif


    <form method="POST" action="{{ route('admin.announcements.update', $announcement->id) }}">
        @csrf
        @method('PUT')

        @include('admin.announcements.form', [ 'announcement' => $announcement,
            'types' => $types,
            'courses' => $courses,])

        <button class="bg-blue-600 text-white px-4 py-2 rounded">更新</button>
        <a href="{{ route('admin.announcements.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
            一覧に戻る
        </a>
    </form>
</div>
@endsection
