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

        <!-- ページタイトル（検索フォームあり） -->
        <x-f_page_title title="{{ $breadcrumbTitle }}一覧" :search="true" searchName="keyword" searchPlaceholder="キーワード検索" />

        <!-- カテゴリ/タグ変換 -->
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

        <!-- カテゴリ一覧 -->
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


        <!-- コンテンツ一覧（文字サイズ変更対象） -->
        <div
            class="performance-list-container
            @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">
            @forelse($learnings as $item)
                @if ($currentTypeId == 4)
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
                    </div>
                @endif
            @empty
                <p>該当するデータがありません。</p>
            @endforelse
        </div>

        <!-- ページネーション -->
        <x-f_pagination :paginator="$learnings" />

        <!-- パンくずリスト -->
        <div class="bread-crumbs">
            {{ Breadcrumbs::render('auto') }}
        </div>

    </div>
@endsection
