@extends('layouts.layout_front')

@section('description', 'プライバシーポリシーページ表示')

@section('keywords', 'キーワード1,キーワード2・・・')

@section('title', 'ページタイトル')

{{-- 該当ページのCSS --}}
@section('pageCss')

@endsection

@section('key_visual')
    <img class="sub-keyvisual" src="{{ asset('assets/images/sub-keyvisual.jpg') }}" alt="サブキービジュアル">
@endsection

{{-- メイン --}}
@section('content')

    <section class="titlesection">
        <div class="titlesection__box">
            <h1 class="pagetitle">ページタイトル</h1>
        </div>
    </section>

    <section class="section">

        <h2 class="section__box--title ">第一セクション</h2>

        <div>
            <h3>サブタイトル</h3>
            <div>
                <p>テキストテキストテキストテキストテキストテキストテキスト</p>
            </div>
        </div>
    </section>

@endsection

{{-- 該当ページ専用JS --}}
@section('pageJs')

@endsection
