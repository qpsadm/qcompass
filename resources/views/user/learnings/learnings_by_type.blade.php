@extends('layouts.f_layout')

@section('title', $breadcrumbTitle . '一覧')

@section('main-content')
<div class="container">

    <x-f_page_title :search="true" title="{{ $breadcrumbTitle }}一覧" />

    @php
    $categories = [
    1 => '参考書籍',
    2 => '参考サイト',
    3 => 'IT資格',
    4 => '製作品',
    5 => 'その他',
    ];

    $tagsMenu = [
    'all' => 'すべて',
    1 => 'WEB制作',
    2 => 'WEBデザイン',
    3 => 'プログラミング',
    4 => 'OA',
    5 => 'その他',
    ];

    $currentTypeId = $typeId ?? 0;
    $currentTag = $currentTag ?? 'all';
    @endphp

    {{-- タグメニュー（製作品以外で表示） --}}
    @if($currentTypeId != 4)
    <div class="category-menu mb-6">
        <ul>
            <li class="{{ $currentTag === 'all' ? 'active' : '' }}">
                <a href="{{ url()->current() }}">
                    すべて ({{ $allCount }})
                </a>
            </li>

            @foreach ($tagsMenu as $key => $label)
            @if ($key === 'all') @continue @endif
            <li class="{{ (string)$currentTag === (string)$key ? 'active' : '' }}">
                <a href="{{ url()->current() }}?tag={{ $key }}">
                    {{ $label }} ({{ $tagCounts[$key] ?? 0 }})
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif


    {{-- 学習コンテンツ一覧 --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($learnings as $item)
        <div class="card p-4 border rounded shadow-sm">

            <h3 class="font-bold text-lg mb-2">{{ $item->title }}</h3>

            @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-40 object-cover mb-2">
            @endif

            <p class="text-gray-700 mb-2">{{ $item->description }}</p>

            <p><strong>種別:</strong> {{ $categories[$currentTypeId] ?? '未分類' }}</p>

            <p><strong>タグ:</strong> {{ $item->tag->name ?? '未設定' }}</p>

            <p><strong>レベル:</strong> {{ $item->level }}</p>
            <p><strong>訓練科名:</strong> {{ $item->course_name }}</p>
            <p><strong>制作期間:</strong> {{ $item->priod }}</p>

            @if($item->url)
            <p><strong>URL:</strong>
                <a href="{{ $item->url }}" target="_blank" class="text-blue-500">{{ $item->url }}</a>
            </p>
            @endif

            {{-- 詳細リンク（製作品のみ表示） --}}
            @if($currentTypeId == 4)
            <a href="{{ route('user.learnings.learnings_info', ['learning' => $item->id, 'type' => $currentTypeId]) }}"
                class="text-blue-500 mt-2 inline-block">
                詳細を見る
            </a>
            @endif
        </div>
        @empty
        <p class="text-gray-500">該当するデータがありません。</p>
        @endforelse
    </div>

    {{-- パンくず --}}
    <div class="bread-crumbs mt-4">
        {{ Breadcrumbs::render('auto') }}
    </div>

</div>
@endsection
