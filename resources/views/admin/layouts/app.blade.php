<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/3.1.2/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/3.1.2/flowbite.min.js"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 h-screen flex flex-col">

    {{-- ナビバー --}}
    @include('layouts.navbar')

    <div class="flex flex-1 pt-16 overflow-hidden">

        {{-- サイドバー --}}
        <aside id="sidebar"
            class="fixed top-16 left-0 w-64 h-full bg-gray-800 text-white transition-transform duration-300 z-40">
            <h2 class="text-2xl font-bold p-4">管理者メニュー</h2>
            <nav class="flex flex-col gap-2 p-2">
                <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-gray-700">ダッシュボード</a>
                <a href="{{ route('admin.users.index') }}" class="block p-2 rounded hover:bg-gray-700">ユーザー管理</a>
                <a href="{{ route('admin.role.index') }}" class="block p-2 rounded hover:bg-gray-700">権限管理</a>
                <a href="{{ route('admin.divisions.index') }}" class="block p-2 rounded hover:bg-gray-700">部署管理</a>
                <a href="{{ route('admin.courses.index') }}" class="block p-2 rounded hover:bg-gray-700">講座管理</a>
            </nav>

            {{-- サイドバー閉じるボタン --}}
            <button id="sidebar-close"
                class="absolute top-4 right-[-1rem] bg-gray-700 p-2 rounded-full text-white z-50">&laquo;</button>
        </aside>

        {{-- メインコンテンツ --}}
        <main id="mainContent" class="flex-1 transition-all duration-300 ml-64 p-6 overflow-y-auto">
            @yield('content')
        </main>

        {{-- サイドバー開くボタン --}}
        <button id="sidebar-open" class="fixed top-20 left-0 z-50 p-2 rounded-r bg-gray-800 text-white hidden">
            &raquo;
        </button>
    </div>

    {{-- フッター（画面下固定） --}}
    <footer class="fixed bottom-0 left-0 w-full bg-gray-800 text-white p-4">
        <p class="text-center text-sm">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const closeBtn = document.getElementById('sidebar-close');
            const openBtn = document.getElementById('sidebar-open');

            // サイドバー閉じる
            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full'); // サイドバーを左に隠す
                mainContent.classList.remove('ml-64'); // メインコンテンツ広げる
                mainContent.classList.add('ml-0');
                openBtn.classList.remove('hidden');
            });

            // サイドバー開く
            openBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full'); // サイドバー表示
                mainContent.classList.remove('ml-0'); // 元のマージンに戻す
                mainContent.classList.add('ml-64');
                openBtn.classList.add('hidden');
            });
        });
    </script>

</body>

</html>
