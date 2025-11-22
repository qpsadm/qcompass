@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md"
    x-data="{ open: false, deleteUrl: '', deleteName: '' }">
    <h1 class="text-2xl font-bold mb-4">ユーザーゴミ箱一覧</h1>

    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('admin.users.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            ユーザー一覧に戻る
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 w-32">ユーザーコード</th>
                    <th class="border px-4 py-2">氏名</th>
                    <th class="border px-4 py-2">所属講座</th>
                    <th class="border px-4 py-2">権限</th>
                    <th class="border px-4 py-2 w-48 text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($trashedUsers as $user)
                <tr>
                    <td class="border px-4 py-2">{{ $user->code }}</td>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">
                        @if($user->courses && $user->courses->count() > 0)
                        {{ $user->courses->pluck('course_name')->join(', ') }}
                        @else
                        未所属
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $user->role->role_name ?? 'なし' }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex items-center justify-center space-x-2 flex-nowrap">

                            <!-- 復元 -->
                            <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center text-green-600 hover:text-green-700">
                                    <img src="{{ asset('assets/images/icon/b_quiz.svg') }}" class="w-4 h-4">
                                    <span class="hidden lg:inline ml-1">復元</span>
                                </button>
                            </form>

                            <!-- 完全削除 -->
                            <button
                                @click="open = true; deleteUrl='{{ route('admin.users.forceDelete', $user->id) }}'; deleteName='{{ $user->name }}';"
                                class="flex items-center text-red-600 hover:text-red-700">
                                <img src="{{ asset('assets/images/icon/b_quiz.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">完全削除</span>
                            </button>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="border px-4 py-2 text-center" colspan="5">ゴミ箱は空です</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $trashedUsers->links() }}
        </div>
    </div>

    {{-- 共通削除モーダル --}}
    <div x-show="open" x-cloak x-transition.opacity.duration.200ms
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div x-show="open" x-transition.scale.duration.200ms
            class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-3 text-center">完全削除確認</h2>
            <p class="text-gray-700 text-center mb-5">
                「<span x-text="deleteName"></span>」を完全に削除しますか？
            </p>
            <div class="flex justify-center space-x-4">
                <button @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    キャンセル
                </button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        完全削除する
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
