@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-bold mb-4">お知らせ編集</h1>

    <form method="POST" action="{{ route('admin.announcements.update', $announcement->id) }}">
        @csrf
        @method('PUT')

        @include('admin.announcements.form', ['announcement' => $announcement])

        <button class="bg-blue-600 text-white px-4 py-2 rounded">更新</button>
    </form>
</div>
@endsection
