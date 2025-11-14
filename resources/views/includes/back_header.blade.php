<header id="header">
    <div class="header container">
        <div class="header-logo">
            <a href="{{ route('top') }}" target="_blank">
                <img src="{{ asset('assets/images/typecode-logo.svg') }}" alt="Logo画像" class="logo">
            </a>
            <h1 class="page_title">タイプコード管理システム</h1>
        </div>

        <div class="login">
            @if (Auth::check())
            <span>ログイン：{{ $login_user->name }}</span>

            <a class="logout" href="{{ route('logout') }}">ログアウト</a>
            @else
            return redirect()->route('admintop');
            @endif

        </div>
    </div>
</header>
