@extends('layouts.f_layout')

@section('title')
@switch($type)
@case(1) 参考書籍 @break
@case(2) 参考サイト @break
@case(3) IT資格 @break
@case(4) 製作品 @break
@default 学習リソース一覧
@endswitch
@endsection

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
<div class="container">

    {{-- ページタイトル --}}
    <h1 class="text-2xl font-bold mb-4">
        @switch($type)
        @case(1) 参考書籍 @break
        @case(2) 参考サイト @break
        @case(3) IT資格 @break
        @case(4) 製作品 @break
        @default 学習リソース一覧
        @endswitch
    </h1>

    {{-- タイプ別リンク --}}
    <div class="mb-4 space-x-2">
        <a href="{{ route('learnings.list') }}" class="btn btn-secondary">すべて</a>
        @for ($i = 1; $i <= 4; $i++)
            <a href="{{ route('learnings.by_type', ['type' => $i]) }}" class="btn btn-secondary">
            @switch($i)
            @case(1) 参考書籍 @break
            @case(2) 参考サイト @break
            @case(3) IT資格 @break
            @case(4) 製作品 @break
            @endswitch
            </a>
            @endfor
    </div>

    {{-- 一覧表示 --}}
    <div class="learnings-list">
        @foreach($learnings as $learning)
        <div class="learning-item mb-4 p-4 border rounded">
            <h2 class="font-bold text-xl mb-2">
                <a href="{{ route('learnings.info', ['learning' => $learning->id]) }}">
                    {{ $learning->title }}
                </a>
            </h2>
            <p>{{ Str::limit($learning->description, 100) }}</p>
            @if($learning->tag)
            <span class="text-sm text-gray-500">{{ $learning->tag->name }}</span>
            @endif
        </div>
        @endforeach
    </div>

    {{-- ページネーション --}}
    <div class="mt-4">
        {{ $learnings->links() }}
    </div>
</div>
@endsection
