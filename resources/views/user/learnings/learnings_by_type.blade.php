@extends('layouts.f_layout')

@section('title', $breadcrumbTitle . '一覧')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_learnings.css') }}">
@endsection

@section('main-content')
<div class="container">

    {{-- ===============================
        ページタイトル + 検索
    =============================== --}}
    <x-f_page_title
        :search="true"
        title="{{ $breadcrumbTitle }}一覧"
        searchName="keyword"
        searchPlaceholder="キーワード検索" />

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

    // 🔑 タグ押下時：検索(keyword)・ページ(page)を必ずリセット
    $baseQuery = request()->except('tag', 'page', 'keyword');
    @endphp

    {{-- ===============================
        タグメニュー（検索リセット）
    =============================== --}}
    <div class="category-menu">
        <ul>

            {{-- すべて --}}
            <li class="{{ $currentTag === 'all' ? 'active' : '' }}">
                <a href="{{ url()->current() . (
                    count($baseQuery) ? '?' . http_build_query($baseQuery) : ''
                ) }}">
                    すべて ({{ $allCount }})
                </a>
            </li>

            {{-- 各タグ --}}
            @foreach ($tagsMenu as $key => $label)
            @if ($key === 'all') @continue @endif

            <li class="{{ (string)$currentTag === (string)$key ? 'active' : '' }}">
                <a href="{{ url()->current() . '?' . http_build_query(
                        array_merge($baseQuery, ['tag' => $key])
                    ) }}">
                    {{ $label }} ({{ $tagCounts[$key] ?? 0 }})
                </a>
            </li>
            @endforeach

        </ul>
    </div>

    {{-- ===============================
        学習コンテンツ一覧
    =============================== --}}
    <div class="list-container">
        @forelse ($learnings as $item)
        <div class="learning-container">
            <div class="container-left">

                <p class="learning-category">
                    {{ $tagsMenu[$item->tag_id] ?? '未設定' }}
                </p>

                <h3 class="learning-title">
                    {{ $item->title }}
                </h3>

                @if ($item->description)
                <p class="learning-description">
                    {!! nl2br(e($item->description)) !!}
                </p>
                @endif

                {{-- 制作品のみ --}}
                @if ($currentTypeId == 4)
                @if ($item->course_name)
                <p><strong>訓練科名：</strong>{{ $item->course_name }}</p>
                @endif

                @if ($item->priod)
                <p><strong>制作期間：</strong>{{ $item->priod }}</p>
                @endif
                @endif

                {{-- 外部リンク --}}
                @if ($item->url)
                <p class="learning-url">
                    <a href="{{ $item->url }}" target="_blank" rel="noopener">
                        詳細をみる
                    </a>
                </p>
                @endif

                {{-- 詳細ページ（制作品のみ） --}}
                @if ($currentTypeId == 4)
                <a
                    href="{{ route('user.learnings.learnings_info', [
                                'learning' => $item->id,
                                'type' => $currentTypeId
                            ]) }}"
                    class="detail-link">
                    詳細を見る
                </a>
                @endif
            </div>

            {{-- 画像 --}}
            @if ($item->image)
            <img
                src="{{ asset('storage/' . $item->image) }}"
                alt="{{ $item->title }}"
                class="learning-img">
            @endif
        </div>
        @empty
        <p class="text-gray-500">
            該当するデータがありません。
        </p>
        @endforelse
    </div>

    {{-- ===============================
        ページネーション（検索・タグ維持）
    =============================== --}}
    <x-f_pagination :paginator="$learnings" />

    {{-- ===============================
        パンくず
    =============================== --}}
    <div class="bread-crumbs mt-4">
        {{ Breadcrumbs::render('auto') }}
    </div>

</div>
@endsection
