@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.f_layout')

@section('title', $breadcrumbTitle . '一覧')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_learnings.css') }}">
@endsection

@section('main-content')
<div class="container">

    <x-f_page_title :search="true" title="{{ $breadcrumbTitle }}一覧" />

    @php
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

    {{-- タグメニュー（※ search 完全リセット） --}}
    <div class="category-menu">
        <ul>
            {{-- すべて --}}
            <li class="{{ $currentTag === 'all' ? 'active' : '' }}">
                <a href="{{ url()->current() }}">
                    すべて ({{ $allCount }})
                </a>
            </li>

            {{-- タグ --}}
            @foreach ($tagsMenu as $key => $label)
            @if ($key === 'all')
            @continue
            @endif
            <li class="{{ (string)$currentTag === (string)$key ? 'active' : '' }}">
                <a href="{{ url()->current() }}?tag={{ $key }}">
                    {{ $label }} ({{ $tagCounts[$key] ?? 0 }})
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    {{-- 制作品一覧 --}}
    <div class="performance-list-container">
        @forelse ($learnings as $item)
        @if ($currentTypeId == 4)
        <a href="{{ route('user.learnings.learnings_info', [
                        'learning' => $item->id,
                        'type' => $currentTypeId
                    ]) }}"
            class="performance-url">

            <div class="learning-performance-container">

                @if ($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="learning-img">
                @endif

                <h3 class="learning-title">{{ $item->title }}</h3>

                <p class="learning-description">
                    {!! nl2br(e(Str::limit($item->description, 100))) !!}
                </p>

                <p class="learning-category">
                    {{ $tagsMenu[$item->tag_id] ?? '未設定' }}
                </p>

            </div>
        </a>
        @endif
        @empty
        <p class="text-gray-500">該当するデータがありません。</p>
        @endforelse
    </div>

    {{-- ページネーション --}}
    <x-f_pagination :paginator="$learnings" />

    {{-- パンくず --}}
    <div class="bread-crumbs mt-4">
        {{ Breadcrumbs::render('auto') }}
    </div>

</div>
@endsection
