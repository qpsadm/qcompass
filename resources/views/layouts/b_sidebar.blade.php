@auth
@if (auth()->user()->role_id === 1)
<aside id="sidebar"
    class="fixed top-16 left-0 w-64 bg-gray-800 text-white p-6 h-full transition-transform duration-300 z-40">
    <h2 class="text-2xl font-bold mb-6">管理者メニュー</h2>

    <nav class="flex flex-col gap-2">
        {{-- ダッシュボード --}}
        <x-nav-link route="admin.dashboard" label="ダッシュボード" />

        {{-- ユーザー管理（サブメニュー） --}}
        <div>
            <button id="userMenuBtn" class="flex items-center w-full p-2 rounded hover:bg-gray-700">
                <img src="{{ asset('assets/images/b_user.svg') }}" alt="ユーザー管理" class="w-4 h-4 mr-2">
                <span>ユーザー管理</span>
            </button>

            <ul id="userSubMenu" class="ml-4 mt-1 space-y-1">
                <li><a href="{{ route('admin.users.index') }}">ユーザー一覧</a></li>
                <li><a href="{{ route('admin.roles.index') }}">権限一覧</a></li>
            </ul>
        </div>
        {{-- アジェンダ管理 --}}
        {{-- <x-nav-link route="admin.agendas" label="アジェンダ管理" /> --}}

        {{-- クイズ管理（サブメニュー） --}}
        <div>
            <button id="quizMenuBtn" class="flex items-center justify-between w-full p-2 rounded hover:bg-gray-700">
                <span>クイズ管理</span>
                <svg class="w-4 h-4 transition-transform" fill="currentColor" viewBox="0 0 20 20" id="quizMenuIcon">
                    <path fill-rule="evenodd" d="M5.23 7.21l4.77 4.77 4.77-4.77" clip-rule="evenodd" />
                </svg>
            </button>
            <ul id="quizSubMenu" class="ml-4 mt-1 space-y-1 hidden">
                {{-- <li><x-nav-link route="admin.quizzes" label="クイズマスタ" /></li> --}}
                {{-- <li><x-nav-link route="admin.questions" label="問題マスタ" /></li> --}}
                {{-- <li><x-nav-link route="admin.question_choices" label="選択肢マスタ" /></li> --}}
                {{-- <li><x-nav-link route="admin.quiz_attempts" label="受験履歴" /></li> --}}
            </ul>
        </div>

        {{-- 日報・求人 --}}
        <x-nav-link route="admin.reports" label="日報" />
        <x-nav-link route="admin.job_offers" label="求人表" />
    </nav>

    {{-- サイトトップ --}}
    <div class="mt-6">
        <a href="{{ url('/') }}" class="block px-3 py-2 bg-gray-600 rounded hover:bg-gray-500 text-center">
            サイトトップへ戻る
        </a>
    </div>

    {{-- サイドバー折りたたみボタン --}}
    <button id="sidebar-close"
        class="absolute top-4 -right-4 bg-gray-700 p-2 rounded-r-md text-white hover:bg-gray-600">
        &laquo;
    </button>
</aside>

{{-- サイドバー開くボタン --}}
<button id="sidebar-open" class="fixed top-20 left-0 bg-gray-800 text-white p-2 rounded-r-md hidden z-50">
    &raquo;
</button>

<script>
    const sidebar = document.getElementById('sidebar');
    const closeBtn = document.getElementById('sidebar-close');
    const openBtn = document.getElementById('sidebar-open');

    // サブメニュー
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userSubMenu = document.getElementById('userSubMenu');
    const userMenuIcon = document.getElementById('userMenuIcon');
    const quizMenuBtn = document.getElementById('quizMenuBtn');
    const quizSubMenu = document.getElementById('quizSubMenu');
    const quizMenuIcon = document.getElementById('quizMenuIcon');

    // サイドバー開閉
    if (sidebar && closeBtn && openBtn) {
        closeBtn.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            openBtn.classList.remove('hidden');
        });
        openBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            openBtn.classList.add('hidden');
        });
    }

    // ユーザー管理サブメニュー
    if (userMenuBtn) {
        userMenuBtn.addEventListener('click', () => {
            userSubMenu.classList.toggle('hidden');
            userMenuIcon.classList.toggle('rotate-180');
        });
    }

    // クイズ管理サブメニュー
    if (quizMenuBtn) {
        quizMenuBtn.addEventListener('click', () => {
            quizSubMenu.classList.toggle('hidden');
            quizMenuIcon.classList.toggle('rotate-180');
        });
    }
</script>
@endif
@endauth
