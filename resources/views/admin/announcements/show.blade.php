@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $announcement->title }}</h1>
    <p class="text-gray-500 mb-2">
        種別: {{ $announcement->type->name ?? '-' }} /
        コース: {{ $announcement->course->name ?? '-' }} /
        投稿日: {{ $announcement->created_at->format('Y-m-d') }}
    </p>
    <div class="bg-gray-100 p-4 rounded">
        {!! nl2br(e($announcement->content)) !!}
    </div>
    <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline mt-4 inline-block">ダッシュボードに戻る</a>
</div>
@endsection
