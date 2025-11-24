@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{ open: false, deleteUrl: '', deleteName: '' }">
    <h1 class="text-2xl font-bold mb-4">実績解除一覧</h1>

    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-4 gap-2">
        <!-- 左：新規作成 -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.achievements_release.create') }}"
                class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>
        </div>

        <!-- 右：検索フォーム -->
        <div x-data="searchBox()" class="flex items-center space-x-2 w-full lg:w-auto">
            <form :action="url" method="GET" class="relative flex-1">
                <input type="text" name="search" x-model="search" placeholder="ユーザー名・実績名・講座で検索"
                    @keydown.enter.prevent="submit()"
                    class="w-full border border-gray-300 rounded px-3 py-2 pr-10 focus:outline-none focus:ring focus:ring-blue-200">

                <!-- ×ボタン -->
                <button type="button" x-show="search" @click="clear()"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 font-bold">&times;</button>
            </form>

            <button @click="submit()"
                class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_search.svg') }}" class="w-4 h-4">
                <span class="hidden lg:inline ml-1">検索</span>
            </button>

            <script>
                function searchBox() {
                    return {
                        search: "{{ request('search') }}",
                        url: "{{ route('admin.achievements_release.index') }}",
                        submit() {
                            const form = document.createElement('form');
                            form.method = 'GET';
                            form.action = this.url;
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'search';
                            input.value = this.search;
                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();
                        },
                        clear() {
                            this.search = '';
                            this.submit();
                        }
                    }
                }
            </script>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr class="text-left text-gray-700 font-medium">
                    <th class="border px-4 py-2 w-32">ユーザー</th>
                    <th class="border px-4 py-2 w-32">実績</th>
                    <th class="border px-4 py-2">所属講座</th>
                    <th class="border px-4 py-2 w-40">達成日時</th>
                    <th class="border px-4 py-2">達成条件詳細</th>
                    <th class="border px-4 py-2 w-60 text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($achievements_release as $AchievementsRelease)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $AchievementsRelease->user->name ?? 'なし' }}</td>
                    <td class="border px-4 py-2">{{ $AchievementsRelease->achievement->title ?? 'なし' }}</td>
                    <td class="border px-4 py-2">
                        @if($AchievementsRelease->user && $AchievementsRelease->user->courses && $AchievementsRelease->user->courses->count() > 0)
                        {{ $AchievementsRelease->user->courses->pluck('course_name')->join(', ') }}
                        @else
                        未所属
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $AchievementsRelease->unlocked_at ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $AchievementsRelease->condition_met ?? '-' }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex items-center justify-center flex-nowrap space-x-2">

                            <!-- 詳細 -->
                            <a href="{{ route('admin.achievements_release.show', $AchievementsRelease->id) }}"
                                class="flex items-center text-green-600 hover:text-green-700">
                                <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">詳細</span>
                            </a>

                            <!-- 編集 -->
                            <a href="{{ route('admin.achievements_release.edit', $AchievementsRelease->id) }}"
                                class="flex items-center text-blue-600 hover:text-blue-700">
                                <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">編集</span>
                            </a>

                            <!-- 削除 -->
                            <button @click="open = true; deleteUrl='{{ route('admin.achievements_release.destroy', $AchievementsRelease->id) }}'; deleteName='{{ $AchievementsRelease->user->name ?? "なし" }} - {{ $AchievementsRelease->achievement->title ?? "なし" }}';"
                                class="flex items-center text-red-600 hover:text-red-700">
                                <img src="{{ asset('assets/images/icon/b_dust.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">削除</span>
                            </button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- ページネーション -->

    </div>

    {{-- 共通削除モーダル --}}
    <div x-show="open" x-cloak x-transition.opacity.duration.200ms
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div x-show="open" x-transition.scale.duration.200ms
            class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
            <p class="text-gray-700 text-center mb-5">
                「<span x-text="deleteName"></span>」を削除しますか？
            </p>
            <div class="flex justify-center space-x-4">
                <button @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    キャンセル
                </button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        削除する
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
@endsection
