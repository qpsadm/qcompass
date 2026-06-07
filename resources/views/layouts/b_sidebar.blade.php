@auth
    @php
        $roleId = auth()->user()->role_id;
        $menus = config('permissions.sidebar');
    @endphp

    <aside id="sidebar"
        class="fixed top-12 left-0 w-64 h-[calc(100vh-4rem)]
           bg-indigo-500  text-neutral-100 p-6 z-40
           transform transition-transform duration-300
           -translate-x-full lg:translate-x-0
           overflow-y-auto hide-scrollbar">

        {{-- SP用 閉じる --}}
        <button id="sidebar-close" class="lg:hidden mb-4 text-sm text-right w-full text-gray-700">
            ✕ 閉じる
        </button>

        <h2 class="bg-blue-100 p-1 text-l text-gray-700 mb-4 text-center rounded">管理メニュー</h2>

        <nav class="space-y-2">
            @foreach ($menus as $menu)
                {{-- 権限制御 --}}
                @if (!isset($menu['roles']) || !in_array($roleId, $menu['roles']))
                    @continue
                @endif

                {{-- 単体リンク --}}
                @if (isset($menu['route']))
                    <a href="{{ route($menu['route'], $menu['params'] ?? []) }}"
                        class="flex items-center p-2 rounded hover:bg-blue-700 hover:text-white">

                        @if (!empty($menu['icon']))
                            <img src="{{ asset('assets/images/icon/' . $menu['icon']) }}" class="h-4 w-4 mr-2" alt="icon">
                        @endif

                        {{ $menu['label'] }}
                    </a>

                    {{-- アコーディオン --}}
                @elseif (isset($menu['children']))
                    <div class="accordion">
                        <button type="button"
                            class="accordion-btn w-full flex justify-between items-center
                               font-semibold p-2 rounded hover:bg-blue-400">

                            <span>
                                @if (!empty($menu['icon']))
                                    <img src="{{ asset('assets/images/icon/' . $menu['icon']) }}"
                                        class="h-4 w-4 mr-2 inline" alt="icon">
                                @endif
                                {{ $menu['label'] }}
                            </span>

                            <span class="accordion-icon transition-transform">▼</span>
                        </button>

                        <ul class="accordion-content ml-4 space-y-1 hidden">
                            @foreach ($menu['children'] as $child)
                                @if (!isset($child['roles']) || !in_array($roleId, $child['roles']))
                                    @continue
                                @endif
                                <li>
                                    <a href="{{ route($child['route'], $child['params'] ?? []) }}"
                                        class="flex items-center px-2 py-1 rounded hover:bg-blue-700 hover:text-white">

                                        @if (!empty($child['icon']))
                                            <img src="{{ asset('assets/images/icon/' . $child['icon']) }}"
                                                class="h-4 w-4 mr-2" alt="icon">
                                        @endif

                                        {{ $child['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach
        </nav>

        {{-- ログアウト --}}
        <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf
            {{-- <button class="w-full text-left p-2 rounded hover:bg-red-600 hover:text-white">
                ログアウト
            </button> --}}
            <button type="submit" class="w-full flex items-center gap-2 p-2 rounded hover:bg-red-600 hover:text-white">
                <img src="{{ asset('assets/images/icon/b_exit.svg') }}" alt="ログアウト" class="h-5 w-5">
                <span class="hidden md:inline">ログアウト</span>
            </button>
        </form>
    </aside>

    @include('partials.sidebar_js')
@endauth
