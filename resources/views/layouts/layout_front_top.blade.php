<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">

    {{-- ページタイトル --}}
    <title>@yield('title')</title>

    {{-- ディスカッション --}}
    <meta
        content="プログラミングでよく使う英単語のタイピングゲームができるWEBアプリです。プログラミングで使う英単語のスペル習得、専門用語とタイピング速度の向上の力がつくと共に、IT業界で役立つ基本的な情報(知っトク情報)も掲載しております。"
        name="description">
    {{-- キーワード --}}
    <meta content="プログラミング,タイピング,単語,HTML,CSS,JavaScript,WordPress,ワードプレス,PHP,Python,英単語,Typing,Webプログラマー" name="keywords">

    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="telephone=no" name="format-detection">

    <!-- faviconを読み込む -->
    <link href="{{ asset('assets/images/icon/favicon.ico') }}" id="favicon" rel="icon">
    <link href="{{ asset('assets/images/icon/apple_touch_icon_180x180.png') }}" rel="apple-touch-icon" sizes="180x180">

    <!-- reset.cssファイルを読み込む -->
    <link href="{{ asset('assets/css/reset.css') }}" rel="stylesheet">
    <!-- 共通CSS -->
    <link href="{{ asset('assets/css/common.css') }}" rel="stylesheet">

    {{-- 独自のCSSファイルを読み込む --}}
    @yield('pageCss')

    <!-- jqueryライブラリ -->
    <script src="{{ asset('assets/js/vendor/jquery-3.6.3.min.js') }}"></script>

    {{-- トークンを読み込む --}}
    <meta content="{{ csrf_token() }}" name="csrf-token">

    <!-- フォント設定 -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@100;300;400;500;700;800;900&display=swap"
        rel="stylesheet">

    <!-- アイコンフォント -->
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v6.4.0/js/all.js"></script>

</head>

<body>
    {{-- ヘッダー --}}
    {{-- @include('includes.front_top_header') --}}
    @include('includes.front_header')

    {{-- メインコンテンツ --}}
    @yield('content')

    {{-- サイドコンテンツ --}}
    @yield('sidecontent')

    {{-- フッター --}}
    @include('includes.front_footer')

    <!-- 共通のjsファイル -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- 独自のJSファイルを読み込む --}}
    @yield('pageJs')
</body>

</html>
