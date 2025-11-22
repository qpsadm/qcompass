@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{ open: false, deleteUrl: '', deleteName: '' }">
    <h1 class="text-2xl font-bold mb-4">ユーザー一覧</h1>

    <div class="flex items-center justify-between mb-4">
        <!-- 左：新規作成 + ゴミ箱 -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.users.create') }}"
                class="bg-blue-500  px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
                <span>新規ユーザー登録</span>
            </a>

            <a href="{{ route('admin.users.trash') }}"
                class="bg-gray-500 px-4 py-2 rounded hover:bg-gray-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_dustbox.svg') }}" class="w-4 h-4">
                <span>ゴミ箱</span>
            </a>
        </div>

        <!-- 右：検索フォーム -->
        <div x-data="searchBox()" class="flex items-center space-x-2">
            <form :action="url" method="GET" class="relative flex-1">
                <input
                    type="text"
                    name="search"
                    x-model="search"
                    placeholder="ユーザー名・コードで検索"
                    @keydown.enter.prevent="submit()"
                    class="w-full border px-2 py-1 rounded pr-8">
                <!-- ×ボタン -->
                <button
                    type="button"
                    x-show="search"
                    @click="clear()"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </form>
            <button @click="submit()"
                class="bg-blue-500 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_dustbox.svg') }}" class="w-4 h-4">
                <span>検索</span>
            </button>
        </div>

        <script>
            function searchBox() {
                return {
                    search: "{{ request('search') }}",
                    url: "{{ route('admin.users.index') }}",
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
                        this.submit(); // クリアしたら即検索
                    }
                }
            }
        </script>

    </div>


    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 w-32">ユーザーコード</th>
                    <th class="border px-4 py-2">氏名</th>
                    <th class="border px-4 py-2">所属講座</th>
                    <th class="border px-4 py-2">権限</th>
                    <th class="border px-4 py-2 w-60 text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $User)
                <tr>
                    <td class="border px-4 py-2">{{ $User->code }}</td>
                    <td class="border px-4 py-2">{{ $User->name }}</td>
                    <td class="border px-4 py-2">
                        @if($User->courses && $User->courses->count() > 0)
                        {{ $User->courses->pluck('course_name')->join(', ') }}
                        @else
                        未所属
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $User->role->role_name ?? 'なし' }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex items-center justify-center flex-nowrap space-x-2">

                            <!-- 詳細 -->
                            <a href="{{ route('admin.users.show', $User->id) }}"
                                class="flex items-center text-green-600 hover:text-green-700">
                                <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">詳細</span>
                            </a>

                            <!-- 編集 -->
                            <a href="{{ route('admin.users.edit', $User->id) }}"
                                class="flex items-center text-blue-600 hover:text-blue-700">
                                <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">編集</span>
                            </a>

                            <!-- 削除 -->
                            <button @click="open = true; deleteUrl='{{ route('admin.users.destroy', $User->id) }}'; deleteName='{{ $User->name }}';"
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
        <div class="mt-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>

    {{-- ✅ 共通削除モーダル --}}
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
    {{-- /共通削除モーダル --}}
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection
