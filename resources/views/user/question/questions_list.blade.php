@extends('layouts.f_layout')

@section('title', '質疑応答一覧')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_qa.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームあり） -->
        <x-f_page_title title="質疑応答一覧" :search="true" :searchName="'keyword'" :searchPlaceholder="'キーワード検索'" />

        <!-- カテゴリ一覧 -->
        <x-f_category_list type="question" :tags="$tags" />

        <!-- ハイライト -->
        @php
            $highlight = function ($text) use ($keywords) {
                foreach ($keywords as $word) {
                    if (!$word) {
                        continue;
                    }
                    $text = preg_replace(
                        '/(' . preg_quote($word, '/') . ')/iu',
                        '<span class="highlight">$1</span>',
                        $text,
                    );
                }
                return $text;
            };
        @endphp

        <!-- コンテンツ一覧 -->
        <div class="content-list
        @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">
            @forelse ($questions as $q)
                <div class="qa-accordion">
                    <div class="question-container">
                        <div class="question-icon"><span>Q</span></div>
                        <div class="question-text">
                            <span>{!! nl2br($highlight($q->content)) !!}</span>
                        </div>
                        <div class="accordion-btn"><span></span></div>
                    </div>
                    <div class="answer-container">
                        <div class="answer-content">
                            <div class="answer-icon"><span>A</span></div>
                            <div class="answer-text">
                                <span>{!! nl2br($highlight($q->answer ?? '-')) !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div>
                    <p>該当する質疑応答はありません</p>
                </div>
            @endforelse
        </div>

        <!-- ページネーション -->
        <x-f_pagination :paginator="$questions" />

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection
