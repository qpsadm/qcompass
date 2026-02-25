<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">

    {{-- ページタイトル --}}
    <title>@yield('title') | QLiP-Compass</title>

    {{-- デスクリプション --}}
    <meta content="QLIPプログラミングスクールの職業訓練生と講師をつなぐ、学習支援から就職支援、終了後のキャリア形成まで幅広くサポートする求職者支援管理システムです。" name="description">

    {{-- キーワード --}}
    <meta content="プログラミング,Webデザイン,システム開発,スキルアップ,キャリア形成,職業訓練,求職者支援管理" name="keywords">

    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="telephone=no" name="format-detection">

    {{-- faviconを読み込む --}}
    <link href="{{ asset('assets/images/icon/favicon.png') }}" id="favicon" rel="icon">

    {{-- reset.cssファイルを読み込む --}}
    <link href="{{ asset('assets/css/reset.css') }}" rel="stylesheet">
    {{-- variable.cssファイルを読み込む --}}
    @php
    // ログインユーザーを取得
    $user = auth()->user();

    // ユーザー設定があればそれを使い、なければデフォルト1
    $themeId = $user->detail->theme_id ?? 1;

    $themeClass = match($themeId) {
    1 => '',
    2 => '_dark',
    3 => '_red',
    4 => '_green',
    5 => '_yellow',
    default => ''
    };
    @endphp

    {{-- 共通cssファイルを読み込む --}}
    <link href="{{ asset('assets/css/f_variable' . $themeClass . '.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/f_common.css') }}" rel="stylesheet">

    {{-- 独自のCSSファイルを読み込む --}}
    @yield('code-page-css')

    {{-- jqueryライブラリ --}}
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    {{-- トークンを読み込む --}}
    <meta content="{{ csrf_token() }}" name="csrf-token">

</head>

<body class="{{ session()->has('impersonator_id') ? 'impersonating' : '' }}">

    {{-- ★ なりすまし中バナー（最上部固定） --}}
    @if(session()->has('impersonator_id'))
    <div class="impersonate-banner">
        <strong>⚠ なりすまし中（管理者）</strong>

        <form method="POST"
            action="{{ route('admin.users.impersonate.leave') }}"
            class="impersonate-exit">
            @csrf
            <button>管理画面に戻る</button>
        </form>
    </div>
    @endif



    {{-- ヘッダー --}}
    @include('includes.f_header')

    {{-- サイドメニュー --}}
    @include('includes.f_side_menu')

    {{-- メインコンテンツ --}}
    <main>
        @yield('main-content')
    </main>

    {{-- フッター --}}
    @include('includes.f_footer')

    {{-- 共通jsファイルを読み込む --}}
    <script src="{{ asset('assets/js/f_common.js') }}"></script>

    {{-- 独自のJSファイルを読み込む --}}
    @yield('code-page-js')

</body>

</html>
