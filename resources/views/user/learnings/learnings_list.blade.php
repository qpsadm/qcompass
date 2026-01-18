@php
use Illuminate\Support\Str;

// 🔑 検索パラメータ名（x-f_page_title と必ず一致させる）
$searchKey = 'keyword';

// 🔑 タグ押下時に保持したいクエリ
// 検索・タグ・ページはリセット
$baseQuery = request()->except($searchKey, 'tag', 'page');
@endphp

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
    @endphp

    {{-- ===============================
        タグメニュー（タグ押下で検索リセット）
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

            {{-- タグ一覧 --}}
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

                @if ($item->image)
                <img
                    src="{{ asset('storage/' . $item->image) }}"
                    class="learning-img"
                    alt="{{ $item->title }}">
                @endif

                <h3 class="learning-title">
                    {{ $item->title }}
                </h3>

                @if ($item->description)
                <p class="learning-description">
                    {!! nl2br(e(Str::limit($item->description, 100))) !!}
                </p>
                @endif

                <p class="learning-category">
                    {{ $tagsMenu[$item->tag_id] ?? '未設定' }}
                </p>

                {{-- 詳細リンク（制作品のみ） --}}
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
        </div>
        @empty
        <p class="text-gray-500">
            該当するデータがありません。
        </p>
        @endforelse
    </div>

    {{-- ===============================
        ページネーション（条件保持）
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
