<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- ナビバー --}}
    @include('layouts.b_navbar')

    <div class="flex pt-16 flex-1 overflow-hidden">

        {{-- サイドバー --}}
        @include('layouts.b_sidebar')

        {{-- メインコンテンツ（ここだけスクロール） --}}
        <main id="mainContent" class="flex-1 transition-all duration-300 ml-64 p-6 pb-24 overflow-y-auto">
            @yield('content')
        </main>

        {{-- サイドバー開くボタン --}}
        <button id="sidebar-open" class="fixed top-20 left-0 z-50 p-2 rounded-r bg-gray-800 text-white hidden">
            &raquo;
        </button>
    </div>
    {{-- ページごとのスクリプト --}}
    @yield('scripts')
    {{-- フッター --}}
    @include('layouts.b_footer')

</body>

</html>
