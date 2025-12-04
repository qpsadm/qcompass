@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{ open: false, deleteUrl: '', deleteTitle: '' }">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">質疑応答一覧</h1>

        {{-- 新規作成ボタン --}}
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('admin.questions.create') }}"
                class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>
        </div>

        {{-- テーブル --}}
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-2 w-12 text-center">No.</th>
                        <th class="border px-4 py-2">講座</th>
                        <th class="border px-4 py-2">タグ</th>
                        <th class="border px-4 py-2">質問タイトル</th>
                        <th class="border px-4 py-2">回答講師</th>
                        <th class="border px-4 py-2 text-center">公開/非公開</th>
                        <th class="border px-4 py-2 w-60 text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($questions as $index => $question)
                        <tr class="hover:bg-gray-50">
                            {{-- 連番 --}}
                            <td class="border px-4 py-2 text-center">
                                {{ ($questions->currentPage() - 1) * $questions->perPage() + $index + 1 }}
                            </td>

                            <td class="border px-4 py-2">{{ $question->course->course_name ?? '-' }}</td>

                            {{-- タグ --}}
                            <td class="border px-4 py-2">
                                {{ $question->tag->name ?? '-' }}
                            </td>

                            <td class="border px-4 py-2">{{ $question->title }}</td>
                            <td class="border px-4 py-2">{{ $question->responder->name ?? '-' }}</td>

                            {{-- 表示/非表示 --}}
                            <td class="border px-4 py-2 w-20 text-center">
                                @if ($question->is_show)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">公開</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非公開</span>
                                @endif
                            </td>

                            {{-- 操作 --}}
                            <td class="border px-4 py-2 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.questions.show', $question->id) }}"
                                        class="flex items-center text-green-600 hover:text-green-700">
                                        <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-4 h-4">
                                        <span class="hidden lg:inline ml-1">詳細</span>
                                    </a>
                                    <a href="{{ route('admin.questions.edit', $question->id) }}"
                                        class="flex items-center text-blue-600 hover:text-blue-700">
                                        <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
                                        <span class="hidden lg:inline ml-1">編集</span>
                                    </a>
                                    <button
                                        @click="open = true; deleteUrl='{{ route('admin.questions.destroy', $question->id) }}'; deleteTitle='{{ $question->title }}';"
                                        class="flex items-center text-red-600 hover:text-red-700">
                                        <img src="{{ asset('assets/images/icon/b_dust.svg') }}" class="w-4 h-4">
                                        <span class="hidden lg:inline ml-1">削除</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border px-4 py-2 text-center text-gray-500">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ページネーション --}}
            <div class="mt-4">
                {{ $questions->appends(request()->query())->links() }}
            </div>
        </div>

        {{-- 共通削除モーダル --}}
        <div x-show="open" x-cloak x-transition.opacity.duration.200ms
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div x-show="open" x-transition.scale.duration.200ms
                class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                <p class="text-gray-700 text-center mb-5">
                    「<span x-text="deleteTitle"></span>」を削除しますか？
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
