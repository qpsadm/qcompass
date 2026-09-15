<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Vite（Tailwindはここだけ） --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 自定義CSS --}}
    <link href="{{ asset('assets/css/b_common.css') }}" rel="stylesheet">

    {{-- favicon --}}
    <link rel="icon" href="{{ asset('assets/images/icon/favicon.png') }}">
</head>

<body class="bg-gray-200 min-h-screen flex flex-col">

    {{-- ナビバー --}}
    @include('layouts.b_navbar')

    {{-- メインラッパー --}}
    <div class="flex pt-16 flex-1 w-full">

        {{-- サイドバー --}}
        @include('layouts.b_sidebar')

        {{-- メインコンテンツ（縦スクロールが正常に動くよう修正） --}}
        <main id="mainContent" class="ml-64 flex-1 w-full p-6 pb-24 min-h-[calc(100vh-4rem)]">
            @yield('content')
        </main>

        <button id="sidebar-open" type="button"
            class="fixed top-20 left-0 z-50 p-2 rounded-r
               bg-red-500 text-white font-bold hidden shadow-lg">
            »
        </button>
    </div>

    {{-- フッター --}}
    @include('layouts.b_footer')

</body>

</html>
