<nav class="fixed z-30 w-full bg-indigo-500  border-b border-gray-200">
    <div class="px-3 py-3 md:px-4 lg:px-5">
        <div class="flex items-center justify-between">

            <!-- 左側：サイドバーボタン + ロゴ -->
            <div class="flex items-center">
                <!-- ロゴ -->
                <a href="{{ route('admin.dashboard') }}" class="self-center ml-2 md:ml-3">
                    <img src="{{ asset('assets/images/logo_star_white.svg') }}" alt="QLIP COMPASS" class="h-8">
                </a>
            </div>

            <!-- なりすましボタン（自分のIDで開始） -->
            <form action="{{ route('admin.users.impersonate', auth()->id()) }}" method="POST" class="inline-block">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 bg-red-500 text-white border border-purple-600 px-4 py-1 rounded font-medium transition hover:bg-amber-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <img src="{{ asset('assets/images/icon/b_course.svg') }}" alt="なりすまし" class="h-5 w-5">
                    <span class="hidden md:inline">なりすまし</span>
                </button>
            </form>

            <!-- 右側：ユーザー情報 + ログアウト + 講座情報 -->
            <div class="flex items-center space-x-2 md:space-x-4">

                <!-- ユーザー名 + ロール（タブレット以上表示） -->
                <span class="hidden md:inline text-neutral-100 whitespace-nowrap">
                    {{ Auth::user()->name ?? 'ゲスト' }}
                    @if (Auth::check() && Auth::user()->role)
                        ({{ Auth::user()->role->role_name }})
                    @endif
                </span>

                <!-- 講座情報（なりすまし時） -->
                @php
                    $courseName = null;
                    if (session()->has('course_id')) {
                        $course = App\Models\Course::find(session('course_id'));
                        $courseName = $course?->course_name;
                    }
                @endphp

                @if ($courseName)
                    <span class="hidden md:inline  text-neutral-100 font-semibold">
                        講座: {{ $courseName }}
                    </span>
                @endif

                <!-- ログアウトボタン -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 bg-yellow-400 text-black border border-gray-600 px-3 py-1 rounded hover:bg-gray-300 transition">
                        <img src="{{ asset('assets/images/icon/b_exit.svg') }}" alt="ログアウト" class="h-5 w-5">
                        <span class="hidden md:inline">ログアウト</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>
