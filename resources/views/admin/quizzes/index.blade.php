@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen">

    <div class="bg-white rounded-lg shadow-md p-6">

        <h1 class="text-2xl font-bold mb-4 text-gray-800">
            クイズ一覧
        </h1>

        <!-- 新規作成ボタン -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.quizzes.create') }}"
                class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition">
                新規作成
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-2 w-12 text-center">ID</th>
                        <th class="border px-4 py-2 w-64">タイトル</th>
                        <th class="border px-4 py-2 w-48">カテゴリ</th>
                        <th class="border px-4 py-2 w-16 text-center">レベル</th>
                        <th class="border px-4 py-2 w-16 text-center">問題数</th>
                        <th class="border px-4 py-2 w-24 text-center">表示</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($quizzes as $quiz)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $quiz->id }}</td>

                        <!-- タイトルクリックで詳細 -->
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.quizzes.show', $quiz->id) }}"
                                class="text-blue-600 hover:underline">
                                {{ $quiz->title }}
                            </a>
                        </td>

                        <td class="border px-4 py-2">{{ $quiz->category?->name ?? '-' }}</td>
                        <td class="border px-4 py-2 text-center">{{ $quiz->level ?? '-' }}</td>
                        <td class="border px-4 py-2 text-center">{{ $quiz->questions_count }}</td>
                        <td class="border px-4 py-2 text-center">
                            @if ($quiz->is_show)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                公開
                            </span>
                            @else
                            <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">
                                非公開
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                            データがありません
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ページネーション -->
        <div class="mt-4">
            {{ $quizzes->links() }}
        </div>

    </div>
</div>
@endsection
