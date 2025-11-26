<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">

    {{-- ページタイトル --}}
    <title>@yield('title')</title>

    {{-- デスクリプション --}}
    <meta content="@yield('description')" name="description">
    {{-- <meta name="description" content="description"> --}}
    {{-- キーワード --}}
    <meta content="プログラミング,タイピング,単語,HTML,CSS,JavaScript,WordPress,ワードプレス,PHP,Python,英単語,Typing,Webプログラマー" name="keywords">
    {{-- <meta name="keywords" content="@yield('keywords')"> --}}
    {{-- <meta name="keywords" content="keywords"> --}}

    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="telephone=no" name="format-detection">

    {{-- faviconを読み込む --}}
    <link href="{{ asset('assets/images/icon/favicon.ico') }}" id="favicon" rel="icon">
    <link href="{{ asset('assets/images/icon/apple_touch_icon_180x180.png') }}" rel="apple-touch-icon" sizes="180x180">

    {{-- reset.cssファイルを読み込む --}}
    <link href="{{ asset('assets/css/reset.css') }}" rel="stylesheet">
    {{-- 共通cssファイルを読み込む --}}
    <link href="{{ asset('assets/css/f_variable.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/f_common.css') }}" rel="stylesheet">

    {{-- 独自のCSSファイルを読み込む --}}
    @yield('code-page-css')

    {{-- jqueryライブラリ --}}
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    {{-- トークンを読み込む --}}
    <meta content="{{ csrf_token() }}" name="csrf-token">

</head>

<body>

    {{-- ヘッダー --}}
    @include('includes.f_header')

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
