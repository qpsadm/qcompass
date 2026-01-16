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
        <div class="card p-4 border rounded shadow-sm">
            <h3 class="font-bold text-lg mb-2">{{ $item->title }}</h3>

            @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" alt="画像" class="w-full h-40 object-cover mb-2">
            @endif

            <p class="text-gray-700 mb-2">{{ $item->description }}</p>

            <p><strong>種別:</strong>
                @switch($item->type)
                @case(1) 参考書籍 @break
                @case(2) 参考サイト @break
                @case(3) IT資格 @break
                @case(4) 製作品 @break
                @endswitch
            </p>

            <p><strong>タグID:</strong> {{ $item->tag_id }}</p>
            <p><strong>レベル:</strong> {{ $item->level }}</p>
            <p><strong>訓練科名:</strong> {{ $item->course_name }}</p>
            <p><strong>制作期間:</strong> {{ $item->priod }}</p>
            <p><strong>表示:</strong> {{ $item->is_show ? '表示' : '非表示' }}</p>
            <p><strong>URL:</strong>
                @if($item->url)
                <a href="{{ $item->url }}" target="_blank" class="text-blue-500">{{ $item->url }}</a>
                @endif
            </p>
            <p><strong>作成日時:</strong> {{ $item->created_at }}</p>
            <p><strong>更新日時:</strong> {{ $item->updated_at }}</p>
            <p><strong>削除日時:</strong> {{ $item->deleted_at }}</p>
            <p><strong>作成者:</strong> {{ $item->created_user_name }}</p>
            <p><strong>更新者:</strong> {{ $item->updated_user_name }}</p>
            <p><strong>削除者:</strong> {{ $item->deleted_user_name }}</p>

            @if($item->type == 4)
            <a href="{{ route('user.learnings.learnings_info', ['learning' => $item->id, 'type' => 4]) }}" class="text-blue-500 mt-2 inline-block">
                詳細を見る
            </a>
            @endif

        </div>
        @endforeach
    </div>

    <div class="bread-crumbs mt-4">
        {{ Breadcrumbs::render('auto') }}
    </div>
</div>
@endsection
