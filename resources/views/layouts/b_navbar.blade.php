<nav class="fixed z-30 w-full bg-blue-300 border-b border-gray-200">
    <div class="px-3 py-3 md:px-4 lg:px-5">
        <div class="flex items-center justify-between">

            <!-- 左側：サイドバーボタン + ロゴ -->
            <div class="flex items-center">


                <!-- ロゴ -->
                <a href="{{ route('admin.dashboard') }}" class="self-center ml-2 md:ml-3">
                    <img src="{{ asset('assets/images/logo_star_white.svg') }}" alt="QLIP COMPASS" class="h-8">
                </a>
            </div>

            <!-- 右側：ユーザー情報 + ログアウト -->
            <div class="flex items-center space-x-2 md:space-x-4">

                <!-- ユーザー名 + ロール（タブレット以上表示） -->
                <span class="hidden md:inline text-gray-700 whitespace-nowrap">
                    {{ Auth::user()->name ?? 'ゲスト' }}
                    @if (Auth::check() && Auth::user()->role)
                        ({{ Auth::user()->role->role_name }})
                    @endif
                </span>

                <!-- ログアウトボタン -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 bg-white text-black border border-gray-300 px-3 py-1 rounded hover:bg-gray-300 transition">
                        <img src="{{ asset('assets/images/icon/b_exit.svg') }}" alt="ログアウト" class="h-5 w-5">
                        <span class="hidden md:inline">ログアウト</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
