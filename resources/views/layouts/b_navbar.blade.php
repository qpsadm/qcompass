<nav class="fixed z-30 w-full bg-white border-b border-gray-200 ">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100">
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 5h14a1 1 0 010 2H3a1 1 0 110-2zm0 6h14a1 1 0 010 2H3a1 1 0 110-2zm0 6h14a1 1 0 010 2H3a1 1 0 110-2z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">
                    {{ config('app.name', 'Laravel') }}
                </span>
            </div>
            <div class="flex items-center">
                <span class="mr-3 text-gray-700 ">{{ Auth::user()->name ?? 'ゲスト' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 hover:underline">ログアウト</button>
                </form>
            </div>
        </div>
    </div>
</nav>
