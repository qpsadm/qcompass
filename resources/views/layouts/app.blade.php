<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 h-screen flex flex-col">

    {{-- ナビバー --}}
    @include('layouts.b_navbar')

    <div class="flex pt-16 flex-1 overflow-hidden">

        {{-- サイドバー --}}
        @include('layouts.b_sidebar')

        {{-- メインコンテンツ --}}
        <main id="mainContent" class="flex-1 transition-all duration-300 ml-64 p-6 overflow-y-auto  pb-24">
            @yield('content')
        </main>

        {{-- サイドバー開くボタン --}}
        <button id="sidebar-open" class="fixed top-20 left-0 z-50 p-2 rounded-r bg-gray-800 text-white hidden">
            &raquo;
        </button>
    </div>

    {{-- フッター固定 --}}
    @include('layouts.b_footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const closeBtn = document.getElementById('sidebar-close');
            const openBtn = document.getElementById('sidebar-open');

            // サイドバー閉じる
            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-0');
                openBtn.classList.remove('hidden');
            });

            // サイドバー開く
            openBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                mainContent.classList.remove('ml-0');
                mainContent.classList.add('ml-64');
                openBtn.classList.add('hidden');
            });
        });
    </script>

</body>

</html>
