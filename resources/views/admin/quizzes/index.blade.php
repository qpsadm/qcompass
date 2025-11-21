@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">クイズ一覧</h1>

        <a href="{{ route('admin.quizzes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            新規作成
        </a>

        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th class="border px-2 py-1">ID</th>
                    <th class="border px-2 py-1">タイトル</th>
                    <th class="border px-2 py-1">種類</th>
                    <th class="border px-2 py-1">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizzes as $quiz)
                <tr>
                    <td class="border px-2 py-1">{{ $quiz->id }}</td>
                    <td class="border px-2 py-1">{{ $quiz->title }}</td>
                    <td class="border px-2 py-1">{{ $types[$quiz->type] ?? '不明' }}</td>
                    <td class="border px-2 py-1 flex flex-wrap gap-2">

                        <!-- 詳細 -->
                        <a href="{{ route('admin.quizzes.show', $quiz->id) }}">
                            詳細
                        </a>
                        <!-- 編集 -->
                        <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="text-blue-600">編集</a>

                        <!-- 問題一覧 -->
                        <a href="{{ route('admin.quizzes.quiz_questions.index', $quiz->id) }}" class="text-green-600">問題一覧</a>

                        <!-- 受験 / プレイ -->
                        <a href="{{ route('admin.quizzes.play', $quiz->id) }}" class="text-purple-600">受験</a>

                        <!-- 削除ボタン -->
                        <button type="button" onclick="openModal({{ $quiz->id }})" class="text-red-600 ml-2">
                            削除
                        </button>

                        <!-- 削除モーダル -->
                        <div id="modal-{{ $quiz->id }}"
                            class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                            <div class="bg-white rounded-lg p-6 w-80">
                                <h2 class="text-lg font-bold mb-4">削除確認</h2>
                                <p class="mb-4">本当にこのクイズを削除しますか？</p>
                                <div class="flex justify-end gap-2">
                                    <button onclick="closeModal({{ $quiz->id }})"
                                        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">キャンセル</button>
                                    <form id="delete-form-{{ $quiz->id }}"
                                        action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">削除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
        document.getElementById('modal-' + id).classList.add('flex');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
        document.getElementById('modal-' + id).classList.remove('flex');
    }
</script>
@endsection
