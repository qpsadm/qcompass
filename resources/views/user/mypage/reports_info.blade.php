@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_form.css') }}">
@endsection

@section('title', '日報詳細')

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームなし） -->
        <x-f_page_title :search="false" title="日報詳細" />

        <!-- コンテンツ詳細（文字サイズ変更対象） -->
        <div
            class="form-content
            @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">

            <!-- 報告日 -->
            <div class="confirm-item">
                <div class="item-label">
                    <label>報告日</label>
                </div>
                <p>{{ $report->date }}</p>
            </div>

            <!-- 日報内容 -->
            <div class="confirm-item">
                <div class="item-label">
                    <label>日報</label>
                </div>
                <p>{!! nl2br(e($report->content)) !!}</p>
            </div>

            <!-- 感想・気づき・質問 -->
            <div class="confirm-item">
                <div class="item-label">
                    <label>感想・気付き・質問</label>
                </div>
                <p>{!! nl2br(e($report->impression)) !!}</p>
            </div>

            <!-- 連絡事項 -->
            <div class="confirm-item">
                <div class="item-label">
                    <label>連絡事項</label>
                </div>
                <p>{!! nl2br(e($report->notice)) !!}</p>
            </div>
        </div>

        <!-- ボタンリスト -->
        <div class="btn-area">
            <a type="button" href="{{ route('user.mypage') }}" class="form-btn">マイページへもどる</a>
        </div>

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection
