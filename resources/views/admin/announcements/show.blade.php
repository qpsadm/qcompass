@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-4xl" x-data="{ deleteOpen: false }">

        {{-- お知らせ詳細カード --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            {{-- タイトル --}}
            <h1 class="text-2xl font-bold mb-4">{{ $announcement->title }}</h1>

            {{-- メタ情報 --}}
            <div class="text-blue-600 mb-4 flex flex-row gap-6">
                <div>種別: {{ $announcement->type->type_name ?? '-' }}</div>
                <div>対象講座: {{ $announcement->course->course_name ?? '全員向け' }}</div>
                <div>投稿日: {{ $announcement->created_at->format('Y-m-d H:i') }}</div>
            </div>

            {{-- 本文 --}}
            <div class="bg-gray-100 p-4 rounded mb-4">
                {!! $announcement->content !!}
            </div>

            {{-- アクションボタン --}}
            <div class="flex gap-3 mb-6">
                <a href="{{ route('admin.announcements.index') }}"
                    class="back bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>

                @if (isset($announcement->id))
                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                        class="save bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">編集</a>
                @endif
            </div>

            {{-- 危険操作ゾーン --}}
            @if (isset($announcement->id))
                <div class="mt-10 pt-6 border-t border-red-200">
                    <h2 class="text-red-600 font-semibold mb-2">
                        ⚠ 危険な操作
                    </h2>

                    <p class="text-sm text-gray-600 mb-4">
                        このお知らせを削除すると、元に戻すことはできません。
                    </p>

                    <button @click="deleteOpen = true" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                        削除する
                    </button>
                </div>
            @endif
        </div>

        {{-- 削除確認モーダル --}}
        @if (isset($announcement->id))
            <div x-show="deleteOpen" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

                <div x-show="deleteOpen" x-transition.opacity x-transition.scale x-cloak
                    class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">

                    <h2 class="text-lg font-bold text-red-600 mb-4 text-center">削除確認</h2>

                    <p class="mb-6 text-gray-700 text-center">
                        「<span class="font-semibold">{{ $announcement->title }}</span>」を削除します。<br>
                        この操作は取り消せません。よろしいですか？
                    </p>

                    <div class="flex justify-center gap-4">
                        <button type="button" @click="deleteOpen = false"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                            キャンセル
                        </button>

                        <form method="POST" action="{{ route('admin.announcements.destroy', $announcement->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
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
        @endif

    </div>
@endsection
