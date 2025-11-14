{{-- メインのサブビュー --}}
<main class="flex container">
    {{-- メインコンテンツ --}}
    <div class="margin">
        {{-- メインコンテンツ内容 --}}
        @yield('maincontents')
    </div>
    {{-- サイドバー --}}
    <div class="margin">
        {{-- サイドバーの内容 --}}
        @yield('sidecontents')
    </div>
</main>
