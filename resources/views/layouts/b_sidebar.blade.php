@auth
    @if (auth()->user()->role_id === 1)
        <!-- サイドバー -->
        <aside id="sidebar"
            class="fixed top-16 left-0 w-64 h-[calc(100vh-4rem)] bg-blue-300 text-white p-6 flex flex-col z-40 overflow-y-auto hide-scrollbar transition-transform duration-300">

            <!-- サイドバー閉じるボタン -->
            <button id="sidebar-close"
                class="absolute top-4 right-4 w-8 h-8 bg-gray-700 text-white flex items-center justify-center rounded-full hover:bg-gray-600 z-50">
                &laquo;
            </button>

            <!-- タイトル -->
            <h2 class="text-2xl font-bold mb-6 flex-shrink-0">管理者メニュー</h2>

            <!-- メニュー -->
            <nav class="flex flex-col gap-2">

                {{-- ダッシュボード --}}
                <x-nav-link route="admin.dashboard" label="ダッシュボード" />

                {{-- ユーザー管理 --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-gray-700">
                        <img src="{{ asset('assets/images/b_user.svg') }}" class="w-4 h-4 mr-2">
                        <span>ユーザー管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.users.index') }}">ユーザー一覧</a></li>
                        <li><a href="{{ route('admin.roles.index') }}">権限一覧</a></li>
                    </ul>
                </div>

                {{-- 講座管理 --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-gray-700">
                        <img src="{{ asset('assets/images/b_course.svg') }}" class="w-4 h-4 mr-2">
                        <span>講座管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        {{-- <li><a href="{{ route('admin.organizers.index') }}">開催者一覧</a></li> --}}
                        <li><a href="{{ route('admin.levels.index') }}">講座種類一覧</a></li>
                        {{-- <li><a href="{{ route('admin.course_types.index') }}">講座分野一覧</a></li> --}}
                    </ul>
                </div>

                {{-- アジェンダ管理（サブメニュー） --}}
                <div>
                    <button id="userMenuBtn" class="flex items-center w-full p-2 rounded hover:bg-gray-700">
                        <img src="{{ asset('assets/images/b_course.svg') }}" alt="講座管理" class="w-4 h-4 mr-2">
                        <span>アジェンダ管理</span>
                    </button>
                </div>
                {{-- お知らせ管理（サブメニュー） --}}
                <div>
                    <button id="userMenuBtn" class="flex items-center w-full p-2 rounded hover:bg-gray-700">
                        <img src="{{ asset('assets/images/b_course.svg') }}" alt="講座管理" class="w-4 h-4 mr-2">
                        <span>お知らせ管理</span>
                    </button>
                </div>
                {{-- 求人票、資格、学習サイト管理（サブメニュー） --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-gray-700">
                        <img src="{{ asset('assets/images/b_course.svg') }}" class="w-4 h-4 mr-2">
                        <span>事務管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.levels.index') }}">求人票管理</a></li>
                        <li><a href="{{ route('admin.levels.index') }}">資格管理</a></li>
                        <li><a href="{{ route('admin.levels.index') }}">学習サイト管理</a></li>
                    </ul>
                </div>
                {{-- クイズ管理（サブメニュー） --}}
                <div>
                    <button id="userMenuBtn" class="flex items-center w-full p-2 rounded hover:bg-gray-700">
                        <img src="{{ asset('assets/images/b_course.svg') }}" alt="講座管理" class="w-4 h-4 mr-2">
                        <span>クイズ管理</span>
                    </button>
                </div>
                {{-- 質疑応答管理（サブメニュー） --}}
                <div>
                    <button id="userMenuBtn" class="flex items-center w-full p-2 rounded hover:bg-gray-700">
                        <img src="{{ asset('assets/images/b_course.svg') }}" alt="講座管理" class="w-4 h-4 mr-2">
                        <span>質疑応答管理</span>
                    </button>
                </div>
                {{-- 日報管理（サブメニュー） --}}
                <div>
                    <button id="userMenuBtn" class="flex items-center w-full p-2 rounded hover:bg-gray-700">
                        <img src="{{ asset('assets/images/b_course.svg') }}" alt="講座管理" class="w-4 h-4 mr-2">
                        <span>日報管理</span>
                    </button>
                </div>

                {{-- システム管理 --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-gray-700">
                        <img src="{{ asset('assets/images/b_course.svg') }}" class="w-4 h-4 mr-2">
                        <span>システム管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.categories.index') }}">カテゴリー管理</a></li>
                        <li><a href="{{ route('admin.levels.index') }}">タグ管理</a></li>
                        <li><a href="{{ route('admin.levels.index') }}">実績管理</a></li>
                        <li><a href="{{ route('admin.daily_quotes.index') }}">今日の一言管理</a></li>
                    </ul>
                </div>
            </nav>

            <!-- メニューとログアウトの間に空白 -->
            <div class="flex-shrink-0 h-24"></div>

            <!-- ログアウトボタン -->
            <div class="mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-3 py-2 bg-red-600 rounded hover:bg-red-500 text-center">
                        ログアウト
                    </button>
                </form>
            </div>
        </aside>

        <!-- サイドバー開くボタン -->
        <button id="sidebar-open" class="fixed top-20 left-0 bg-gray-800 text-white p-2 rounded-r-md z-50 hidden">
            &raquo;
        </button>

        <script>
            // サイドバー開閉
            const sidebar = document.getElementById('sidebar');
            const openBtn = document.getElementById('sidebar-open');
            const closeBtn = document.getElementById('sidebar-close');

            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                openBtn.classList.remove('hidden');
            });

            openBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                openBtn.classList.add('hidden');
            });

            // アコーディオン
            document.querySelectorAll('.accordion-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const content = btn.nextElementSibling;
                    content.classList.toggle('hidden');
                });
            });
        </script>

        <style>
            /* スクロール可能だがスクロールバー非表示 */
            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    @endif
@endauth
