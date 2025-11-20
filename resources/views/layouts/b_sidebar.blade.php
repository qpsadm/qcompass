@auth
    @if (auth()->user()->role_id === 8)
        <aside id="sidebar"
            class="fixed top-16 left-0 w-64 h-[calc(100vh-4rem)] bg-blue-300 p-6 flex flex-col z-40 overflow-y-auto hide-scrollbar transition-transform duration-300">

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
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-blue-700 hover:text-white">
                        <img src="{{ asset('assets/images/b_user.svg') }}" class="w-4 h-4 mr-2">
                        <span>ユーザー管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.users.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">ユーザー一覧</a>
                        </li>
                    </ul>
                </div>

                {{-- 講座管理 --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-blue-700 hover:text-white ">
                        <img src="{{ asset('assets/images/b_course.svg') }}" class="w-4 h-4 mr-2">
                        <span>講座管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.organizers.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">開催者一覧</a>
                        </li>
                        <li><a href="{{ route('admin.levels.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">講座種類一覧</a>
                        </li>
                        <li><a href="{{ route('admin.courses.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">講座一覧</a>
                        </li>
                        <li><a href="{{ route('admin.course_type.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">講座分野一覧</a>
                        </li>
                        <li><a href="{{ route('admin.course_category.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">講座カテゴリー</a>
                        </li>

                        <li><a href="{{ route('admin.questions.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">質疑応答一覧</a>
                        </li>
                    </ul>
                </div>

                {{-- アジェンダ管理 --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-blue-700 hover:text-white">
                        <img src="{{ asset('assets/images/b_course.svg') }}" class="w-4 h-4 mr-2">
                        <span>アジェンダ管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.agendas.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">アジェンダ一覧</a>
                        </li>
                        <li><a href="{{ route('admin.agenda_files.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">アジェンダファイル一覧</a>
                        </li>
                        <li><a href="{{ route('admin.agendas.create') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">新規作成</a>
                        </li>
                    </ul>
                </div>

                {{-- お知らせ管理 --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-blue-700 hover:text-white">
                        <img src="{{ asset('assets/images/b_course.svg') }}" class="w-4 h-4 mr-2">
                        <span>お知らせ管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.notices.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">一覧</a>
                        </li>
                        <li><a href="{{ route('admin.notices.create') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">新規作成</a>
                        </li>
                    </ul>
                </div>

                {{-- 事務管理 --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-blue-700 hover:text-white">
                        <img src="{{ asset('assets/images/b_course.svg') }}" class="w-4 h-4 mr-2">
                        <span>事務管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.levels.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">求人票管理</a>
                        </li>
                        <li><a href="{{ route('admin.levels.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">資格管理</a>
                        </li>
                        <li><a href="{{ route('admin.levels.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">学習サイト管理</a>
                        </li>
                    </ul>
                </div>

                {{-- クイズ管理 --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-blue-700 hover:text-white">
                        <img src="{{ asset('assets/images/b_course.svg') }}" class="w-4 h-4 mr-2">
                        <span>クイズ管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.quizzes.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">一覧</a>
                        </li>
                        <li><a href="{{ route('admin.quizzes.create') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">新規作成</a>
                        </li>
                    </ul>
                </div>

                {{-- 日報管理 --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-blue-700 hover:text-white">
                        <img src="{{ asset('assets/images/b_course.svg') }}" class="w-4 h-4 mr-2">
                        <span>日報管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.reports.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">一覧</a>
                        </li>
                    </ul>
                </div>

                {{-- システム管理 --}}
                <div class="accordion">
                    <button class="accordion-btn flex items-center w-full p-2 rounded hover:bg-blue-700 hover:text-white">
                        <img src="{{ asset('assets/images/b_course.svg') }}" class="w-4 h-4 mr-2">
                        <span>システム管理</span>
                    </button>
                    <ul class="accordion-content hidden ml-4 mt-1 space-y-1">
                        <li><a href="{{ route('admin.roles.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">権限一覧</a>
                        </li>

                        <li><a href="{{ route('admin.categories.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">カテゴリー管理</a>
                        </li>
                        <li><a href="{{ route('admin.tags.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">タグ管理</a>
                        </li>
                        <li><a href="{{ route('admin.levels.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">実績管理</a>
                        </li>
                        <li><a href="{{ route('admin.daily_quotes.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">今日の一言管理</a>
                        </li>
                        <li><a href="{{ route('admin.quotes.index') }}"
                                class="block px-2 py-1 rounded hover:bg-blue-700 hover:text-white transition-colors duration-200">今日の一言(悪魔合体)管理</a>
                        </li>
                    </ul>
                </div>

            </nav>

            <!-- 空白 -->
            <div class="flex-shrink-0 h-24"></div>

            <!-- ログアウト -->
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

            // ===== アコーディオン（保存 & 復元） =====
            const accordions = document.querySelectorAll('.accordion');
            const STORAGE_KEY = "sidebar_open_index";

            // ⭐ ページ読み込み時に前回開いたアコーディオンを復元
            const savedIndex = localStorage.getItem(STORAGE_KEY);
            if (savedIndex !== null) {
                accordions.forEach((acc, index) => {
                    const content = acc.querySelector('.accordion-content');
                    if (index == savedIndex) {
                        content.classList.remove('hidden'); // 前回開いていたものを開く
                    } else {
                        content.classList.add('hidden'); // 他は閉じる
                    }
                });
            }

            // ⭐ アコーディオンをクリックしたとき
            accordions.forEach((acc, index) => {
                const btn = acc.querySelector('.accordion-btn');
                const content = acc.querySelector('.accordion-content');

                btn.addEventListener('click', () => {

                    // 他のアコーディオンを閉じる
                    accordions.forEach((otherAcc, otherIndex) => {
                        const otherContent = otherAcc.querySelector('.accordion-content');
                        if (otherIndex !== index) otherContent.classList.add('hidden');
                    });

                    // このアコーディオンをトグル
                    content.classList.toggle('hidden');

                    // 開いたなら保存 / 閉じたなら削除
                    if (!content.classList.contains('hidden')) {
                        localStorage.setItem(STORAGE_KEY, index);
                    } else {
                        localStorage.removeItem(STORAGE_KEY);
                    }
                });
            });
        </script>



        <style>
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
