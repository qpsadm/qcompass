@extends('layouts.f_layout')

@section('title', $breadcrumbTitle . '一覧')

@section('main-content')
<div class="container">

    <x-f_page_title :search="true" title="{{ $breadcrumbTitle }}一覧" />

    <div class="mb-4 space-x-2">
        <a href="{{ route('user.learnings.learnings_list') }}" class="btn btn-secondary">すべて</a>
        @for ($i = 1; $i <= 4; $i++)
            <a href="{{ route('user.learnings.learnings_by_type', ['type' => $i]) }}" class="btn btn-secondary">
            @switch($i)
            @case(1) 参考書籍 @break
            @case(2) 参考サイト @break
            @case(3) IT資格 @break
            @case(4) 製作品 @break
            @endswitch
            </a>
            @endfor
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($learnings as $item)
        <div class="card p-4 border rounded">
            <h3 class="font-bold">{{ $item->title }}</h3>
            <p>{{ Str::limit($item->description, 100) }}</p>
            <a href="{{ route('user.learnings.learnings_info', ['learning' => $item->id, 'type' => $type]) }}" class="text-blue-500">詳細を見る</a>
        </div>
        @endforeach
    </div>

    <div class="bread-crumbs">
        {{ Breadcrumbs::render('auto') }}
    </div>
</div>
@endsection
