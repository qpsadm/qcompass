@auth
    @php
        $roleId = auth()->user()->role_id;
        $menus = config('permissions.sidebar');
    @endphp

    <aside id="sidebar"
        class="fixed top-16 left-0 w-64 h-[calc(100vh-4rem)]
           bg-gray-500 text-neutral-100 p-6 z-40
           transform transition-transform duration-300
           overflow-y-auto hide-scrollbar
           flex-shrink-0"
        style="background-color: #4682b4;">

        {{-- 閉じるボタン --}}
        <div class="text-left mb-4">
            <button id="sidebar-close" type="button"
                class="delete text-md font-bold text-white bg-black/20 hover:bg-black/40 px-3 py-1  transition-colors hidden rounded-md">
                ✕ 閉じる
            </button>
        </div>

        <h2 class="bg-aa-100 p-2 text-xl font-medium mb-4 text-center text-white rounded border">管理メニュー</h2>

        <nav class="space-y-2">
            @foreach ($menus as $menu)
                @if (!isset($menu['roles']) || !in_array($roleId, $menu['roles']))
                    @continue
                @endif

                @if (isset($menu['route']))
                    <a href="{{ route($menu['route'], $menu['params'] ?? []) }}"
                        class="flex items-center p-2 rounded text-white hover:bg-yellow-600 transition-colors duration-200">
                        @if (!empty($menu['icon']))
                            <img src="{{ asset('assets/images/icon/' . $menu['icon']) }}" class="h-4 w-4 mr-2"
                                alt="icon" style="filter: brightness(0) invert(1);">
                        @endif
                        {{ $menu['label'] }}
                    </a>
                @elseif (isset($menu['children']))
                    <div class="accordion">
                        <button type="button"
                            class="accordion-btn w-full flex justify-between items-center font-semibold p-2 rounded text-white hover:bg-blue-400 transition-colors duration-200">
                            <span class="flex items-center">
                                @if (!empty($menu['icon']))
                                    <img src="{{ asset('assets/images/icon/' . $menu['icon']) }}" class="h-4 w-4 mr-2"
                                        alt="icon" style="filter: brightness(0) invert(1);">
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
                                        class="flex items-center px-2 py-1 rounded hover:bg-yellow-600 hover:text-white">
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
    </aside>

    @include('partials.sidebar_js')
@endauth
