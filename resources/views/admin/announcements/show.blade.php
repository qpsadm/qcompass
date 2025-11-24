@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        {{-- タイトル --}}
        <h1 class="text-2xl font-bold mb-4">{{ $announcement->title }}</h1>

        {{-- メタ情報 --}}
        <div class="text-gray-500 mb-4 text-sm">
            <span>種別: {{ $announcement->type->type_name ?? '-' }}</span> /
            <span>コース: {{ $announcement->course->course_name ?? '全員向け' }}</span> /
            <span>投稿日: {{ $announcement->created_at->format('Y-m-d') }}</span>
        </div>

        {{-- 本文 --}}
        <div class="bg-gray-100 p-4 rounded mb-4">
            {!! $announcement->content !!}
        </div>

        {{-- アクションボタン --}}
        <div class="flex gap-3">
            <a href="{{ route('admin.announcements.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
            @if(isset($announcement->id))
            <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">編集</a>
            @endif
        </div>
    </div>
</div>
@endsection
