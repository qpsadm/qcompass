<header id="header" class="header">
    <div class="container">

        <!-- ヘッダーロゴ -->
        <h1 class="headerLogo">
            <a href="{{ route('top') }}"><img src="" alt="タイプコード" srcset=""></a>
        </h1>

        <!-- ハンバーガーメニュー部分 -->
        <div class="hanmburger">
            <!-- ハンバーガーメニューの表示・非表示を切り替えるチェックボックス -->
            <input id="drawerInput" class="drawerHidden" type="checkbox" />
            <!-- ハンバーガーメニュー -->
            <label for="drawerInput" class="drawerOpen">
                <span></span>
            </label>

            <!-- ナビゲーション -->
            <nav class="navContent">
                <ul class="navList">
                    <li class="game">
                        <a href="{{ route('game') }}">ゲーム</a>
                    </li>
                    <li class="dictionary">
                        <a href="{{ route('dictionary') }}">辞書</a>
                    </li>
                    <li class="ranking">
                        <a href="{{ route('ranking') }}">ランキング</a>
                    </li>
                    <li class="MyScore">
                        <a href="{{ route('myscore') }}">MyScore</a>
                    </li>
                    <li class="shittoku">
                        <a href="{{ route('knowhow') }}">知っトク情報</a>
                    </li>
                    <li class="contact">
                        <a href="{{ route('contact') }}">お問い合わせ</a>
                    </li>
                </ul>
            </nav>

        </div>

        <!-- g-nav pc -->
        {{-- <nav id="menu-pc">
            <ul class="nav-pc">
                <li>
                    <a href="{{ route('top') }}">
                        <div>
                            <img src="{{ asset('assets/images/menu_icon/station_list_icon.svg') }}" alt="タイプコード"
                                width="30" height="30">
                        </div>
                        タイプコード
                    </a>
                </li>
                <li>
                    <a href="{{ route('game') }}">
                        <div>
                            <img src="{{ asset('assets/images/menu_icon/station_area_icon.svg') }}" alt="About"
                                width="30" height="30">
                        </div>
                        ゲーム画面
                    </a>
                </li>
                <li>
                    <a href="{{ route('dictionary') }}">
                        <div>
                            <img src="{{ asset('assets/images/menu_icon/station_area_icon.svg') }}" alt="辞書"
                                width="30" height="30">
                        </div>
                        辞書
                    </a>
                </li>
                <li>
                    <a href="{{ route('ranking') }}">
                        <div>
                            <img src="{{ asset('assets/images/menu_icon/station_detail_icon.svg') }}" alt="ランキング"
                                width="30" height="30">
                        </div>
                        ランキング
                    </a>
                </li>
                <li>
                    <a href="{{ route('myscore') }}">
                        <div>
                            <img src="{{ asset('assets/images/menu_icon/activity_list_icon.svg') }}" alt="マイスコア"
                                width="30" height="30">
                        </div>
                        マイスコア
                    </a>
                </li>
                <li>
                    <a href="{{ route('knowhow') }}">
                        <div>
                            <img src="{{ asset('assets/images/menu_icon/blog_list_icon.svg') }}" alt="知っトク情報"
                                width="30" height="30">
                        </div>
                        知っトク情報
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}">
                        <div>
                            <img src="{{ asset('assets/images/menu_icon/like_icon.svg') }}" alt="お問い合わせ"
                                width="30" height="30">
                        </div>
                        お問い合わせ
                    </a>
                </li>
            </ul>
        </nav> --}}
    </div>

</header>
