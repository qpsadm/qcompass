@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">開催者詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>開催者名:</strong> {{ $Organizer->name }}</p>

    </div>
    <a href="{{ route('admin.organizers.edit', $Organizer->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('admin.organizers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection
