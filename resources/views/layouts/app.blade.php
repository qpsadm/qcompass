<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Vite（Tailwindはここだけ） --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- favicon --}}
    <link rel="icon" href="{{ asset('assets/images/icon/favicon.png') }}">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- ナビバー --}}
    @include('layouts.b_navbar')

    {{-- 全体ラッパー（画面自体はスクロールしない） --}}
    <div class="flex pt-16 flex-1 overflow-hidden">

        {{-- サイドバー --}}
        @include('layouts.b_sidebar')

        {{-- メインコンテンツ（ここだけスクロール） --}}
        <main
            id="mainContent"
            class="flex-1 ml-64 p-6 pb-24
                   overflow-y-auto hide-scrollbar
                   transition-all duration-300">

            @yield('content')
        </main>

        {{-- SP用 サイドバー開くボタン --}}
        <button
            id="sidebar-open"
            class="fixed top-20 left-0 z-50 p-2 rounded-r
                   bg-gray-800 text-white lg:hidden hidden">
            »
        </button>
    </div>

    {{-- ページ個別JS --}}
    @yield('scripts')

    {{-- フッター --}}
    @include('layouts.b_footer')

</body>

</html>
