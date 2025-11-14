<!-- ヘッダー -->
<header class="header" id="header">
    <div class="container">
        <!-- ヘッダーロゴ -->
        <h1 class="headerLogo">
            <a href="{{ route('top') }}"><img alt="@yield('title')"
                    src="{{ asset('assets/images/typecode-logo.svg') }}"></a>
        </h1>
        <!-- ハンバーガーメニュー部分 -->
        <div class="hanmburger">
            <!-- ハンバーガーメニューの表示・非表示を切り替えるチェックボックス -->
            <input class="drawerHidden" id="drawerInput" type="checkbox" />
            <!-- ハンバーガーメニュー -->
            <label class="drawerOpen" for="drawerInput">
                <span></span>
            </label>
            <!-- ナビゲーション -->
            <nav class="navContent">
                <ul class="navList">
                    <li class="game">
                        <a href="{{ route('game') }}">ゲーム</a>
                    </li>
                    <li class="home">
                        <a href="{{ route('top') }}">HOME</a>
                    </li>
                    <li class="dictionary">
                        <a href="{{ route('dictionary') }}">辞書</a><!-- リンク先はデフォルトを英単語にする -->
                    </li>
                    <li class="ranking">
                        <a href="{{ route('ranking') }}">ランキング</a>
                    </li>
                    <li class="myScore">
                        <a href="{{ route('myscore') }}">マイスコア</a>
                    </li>
                    <li class="shittoku">
                        <a href="{{ route('knowhow') }}">知っトク情報</a>
                    </li>
                    <li class="upDate">
                        <a href="{{ route('article') }}">更新情報</a>
                    </li>
                    </li>
                    <li class="about">
                        <a href="{{ route('about') }}">アバウト</a>
                    </li>
                    <li class="contact">
                        <a href="{{ route('contact') }}">お問い合わせ</a>
                    </li>
                    <li class="terms">
                        <a href="{{ route('terms') }}">利用規約</a>
                    </li>
                    <li class="privacy">
                        <a href="{{ route('privacypolicy') }}">プライバシーポリシー</a>
                    </li>
                    {{-- <li class="admin">
                        <a href="{{ route('admintop') }}">管理者ログイン</a>
                    </li> --}}
                </ul>
            </nav>
        </div>
    </div>
</header>
