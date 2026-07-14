@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-4">質疑応答一覧</h1>

        <!-- 新規作成 -->
        <div class="flex justify-between mb-4">
            <a href="{{ route('admin.questions.create') }}"
                class="bg-yellow-400 border border-gray-200 px-4 py-2 text-black rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                {{-- <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4"> --}}
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>
        </div>

        <!-- ページネーション（上） -->
        {{-- {{ $questions->links() }} --}}

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <!-- No. -->
                        <th class="border px-4 py-2 w-12 text-center">No.</th>


                        <!-- タグ -->
                        <th class="border px-4 py-2">タグ</th>

                        <!-- 質問タイトル -->
                        <th class="border px-4 py-2">質問タイトル</th>


                        <!-- 公開状態 -->
                        <th class="border px-4 py-2 w-24 text-center">公開状態</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($questions as $question)
                        <tr class="hover:bg-gray-50">
                            <!-- No. -->
                            <td class="border px-4 py-2 text-center">
                                {{ ($questions->currentPage() - 1) * $questions->perPage() + $loop->iteration }}
                            </td>

                            <!-- タグ -->
                            <td class="border px-4 py-2">
                                {{ $question->tag->name ?? '-' }}
                            </td>

                            <!-- タイトル（詳細リンク） -->
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.questions.show', $question->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $question->title }}
                                </a>
                            </td>

                            <!-- 公開状態 -->
                            <td class="border px-4 py-2 text-center">
                                @if ($question->is_show)
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

        <!-- ページネーション（下） -->
        <div class="mt-4">
            {{ $questions->links() }}
        </div>

    </div>
@endsection
