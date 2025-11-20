@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">

            <h1 class="text-2xl font-bold mb-4">アジェンダ一覧</h1>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('admin.agendas.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    新規作成
                </a>
            </div>

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">アジェンダ名</th>
                        <th class="border px-4 py-2">表示</th>
                        <th class="border px-4 py-2">承認</th>
                        <th class="border px-4 py-2">作成者</th>
                        <th class="border px-4 py-2 text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agendas as $agenda)
                        <tr class="hover:bg-gray-50">

                            <td class="border px-4 py-2">{{ $agenda->agenda_name }}</td>
                            <td class="border px-4 py-2">{{ $agenda->is_show ? '表示' : '非表示' }}</td>
                            <td class="border px-4 py-2">{{ $agenda->accept === 'yes' ? '承認済み' : '下書き' }}</td>
                            <td class="border px-4 py-2">{{ optional($agenda->createdUser)->name ?? '不明' }}</td>

                            {{-- 操作 --}}
                            <td class="border px-4 py-2 text-center">
                                <button type="button" class="text-green-500 hover:underline"
                                    data-content="{{ $agenda->content }}" onclick="openPreview(this)">
                                    プレビュー
                                </button>

                                <a href="{{ route('admin.agendas.show', $agenda->id) }}"
                                    class="text-blue-500 hover:underline mr-2">
                                    詳細
                                </a>

                                <a href="{{ route('admin.agendas.edit', $agenda->id) }}"
                                    class="text-blue-500 hover:underline mr-2">
                                    編集
                                </a>
                                <button type="button" class="text-red-500 hover:underline"
                                    onclick="openDeleteModal({{ $agenda->id }}, '{{ $agenda->agenda_name }}')">
                                    削除
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">
                                アジェンダはまだ登録されていません。
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 削除確認モーダル --}}
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">削除の確認</h2>
                <p class="mb-6" id="deleteMessage">本当に削除しますか？</p>
                <div class="flex justify-end gap-4">
                    <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        キャンセル
                    </button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            削除
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(id, name) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const message = document.getElementById('deleteMessage');

            form.action = "{{ url('admin/agendas') }}/" + id;
            message.textContent = `「${name}」を本当に削除しますか？この操作は取り消せません。`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }
    </script>
    <script>
        function openPreview(button) {
            const contentHTML = button.getAttribute('data-content') || '';

            const previewWindow = window.open('', 'PreviewWindow', 'width=800,height=600');
            if (!previewWindow) {
                alert('ポップアップブロックを解除してください。');
                return;
            }

            previewWindow.document.open();
            previewWindow.document.write(`
        <!DOCTYPE html>
        <html lang="ja">
            <head>
                <meta charset="UTF-8">
                <title>内容・概要 プレビュー</title>
                <link rel="stylesheet" href="/css/app.css">
                <link rel="stylesheet" href="public/assets/css/test.css">
            </head>
            <body>
                <h2 class="text-xl font-bold mb-4">内容・概要 プレビュー</h2>
                <div class="prose">${contentHTML}</div>
            </body>
        </html>
    `);
            previewWindow.document.close();
        }
    </script>
@endsection
