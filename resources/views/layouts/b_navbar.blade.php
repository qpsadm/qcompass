<nav class="fixed z-30 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <!-- サイドバー開閉ボタン -->
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100">
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 5h14a1 1 0 010 2H3a1 1 0 110-2zm0 6h14a1 1 0 010 2H3a1 1 0 110-2zm0 6h14a1 1 0 010 2H3a1 1 0 110-2z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- アプリロゴ（画像） -->
                <a href="{{ route('admin.dashboard') }}" class="self-center">
                    <img src="{{ asset('assets/images/f_site-logo.svg') }}" alt="QLIP COMPASS" class="h-8">
                </a>
            </div>

            <div class="flex items-center">
                <!-- ユーザー名とロール -->
                <span class="mr-3 text-gray-700">
                    {{ Auth::user()->name ?? 'ゲスト' }}
                    @if(Auth::check() && Auth::user()->role)
                    ({{ Auth::user()->role->role_name }})
                    @endif
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 bg-white text-black border border-gray-300 px-3 py-1 rounded hover:bg-gray-300 transition">
                        <img src="{{ asset('assets/images/icon/b_exit.svg') }}" alt="ログアウト" class="h-5 w-5">
                        ログアウト
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
