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

        {{-- ===============================
        ページタイトル + 検索
        keyword で検索
    =============================== --}}
        <x-f_page_title :search="true" title="{{ $breadcrumbTitle }}一覧" searchName="keyword" searchPlaceholder="キーワード検索" />

        @php
            $categories = [
                1 => '参考書籍',
                2 => '参考サイト',
                3 => 'IT資格',
                4 => '制作品',
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

        {{-- タグメニュー --}}

        <div class="category-menu">
            <ul>
                <li class="{{ $currentTag === 'all' ? 'active' : '' }}">
                    <a href="{{ url()->current() }}">
                        すべて ({{ $allCount }})
                    </a>
                </li>

                @foreach ($tagsMenu as $key => $label)
                    @if ($key === 'all')
                        @continue
                    @endif
                    <li class="{{ (string) $currentTag === (string) $key ? 'active' : '' }}">
                        <a href="{{ url()->current() }}?tag={{ $key }}">
                            {{ $label }} ({{ $tagCounts[$key] ?? 0 }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>


        {{-- 学習コンテンツ一覧 --}}
        <div class="performance-list-container">
            @forelse($learnings as $item)
                @if ($currentTypeId == 4)
                    {{-- <a href="{{ route('user.learnings.learnings_info', ['learning' => $item->id, 'type' => $currentTypeId]) }}"
                        class="performance-url"> --}}
                        <div class="learning-performance-container">

                            <a href="{{ route('user.learnings.learnings_info', ['learning' => $item->id, 'type' => $currentTypeId]) }}"
                        class="performance-url"></a>

                            <div class="learning-img">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="img">
                                @endif
                            </div>

                            <h3 class="learning-title">{{ $item->title }}</h3>

                            <p class="learning-description">
                                {!! nl2br(e(Str::limit($item->description, 100))) !!}
                            </p>

                            <p class="learning-category">{{ $tagsMenu[$item->tag_id] ?? '未設定' }}</p>


                            {{-- <p><strong>レベル:</strong> {{ $item->level }}</p> --}}

                            {{-- @if ($currentTypeId == 4)
                            <p><strong>訓練科名:</strong> {{ $item->course_name }}</p>
                <p><strong>制作期間:</strong> {{ $item->priod }}</p>
                @endif
                @if ($item->url)
                <p class="learning-url"><a href="{{ $item->url }}" target="_blank">詳細をみる</a>
                </p>
                @endif --}}



                        </div>
                    {{-- </a> --}}
                @endif
            @empty
                <p class="text-gray-500">該当するデータがありません。</p>
            @endforelse
        </div>

        {{-- ページネーション --}}
        <x-f_pagination :paginator="$learnings" />

        {{-- パンくず --}}
        <div class="bread-crumbs">
            {{ Breadcrumbs::render('auto') }}
        </div>

    </div>

@endsection
