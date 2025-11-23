@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">アジェンダ詳細</h1>

        <table class="table-auto w-full border-collapse">
            <tbody>
                <tr>
                    <td class="border px-4 py-2 font-bold">アジェンダ名</td>
                    <td class="border px-4 py-2">{{ $agenda->agenda_name }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">カテゴリ</td>
                    <td class="border px-4 py-2">{{ $agenda->category?->name ?? '未設定' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">表示フラグ</td>
                    <td class="border px-4 py-2">{{ $agenda->is_show ? '表示' : '非表示' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">承認</td>
                    <td class="border px-4 py-2">{{ $agenda->status === 'yes' ? '承認済み' : '下書き' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">作成者</td>
                    <td class="border px-4 py-2">{{ $agenda->createdUser?->name ?? '不明' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">更新者</td>
                    <td class="border px-4 py-2">{{ $agenda->updatedUser?->name ?? 'なし' }}</td>
                </tr>
            </tbody>
        </table>

        {{-- プレビューボタン --}}
        <div class="flex gap-2 mt-6">
            <button type="button"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition preview-button"
                data-content='@json($agenda->content)'>
                プレビュー
            </button>
            <a href="{{ route('admin.agendas.edit', $agenda->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                編集
            </a>
            <a href="{{ route('admin.agendas.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                一覧に戻る
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.preview-button').forEach(btn => {
        btn.addEventListener('click', function() {
            // JSON文字列として取得してパース
            let contentHTML = this.dataset.content;
            try {
                contentHTML = JSON.parse(contentHTML);
            } catch (e) {
                console.error('JSON parse error', e);
                contentHTML = '';
            }

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
                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
            </head>
            <body class="p-6">
                <h2 class="text-xl font-bold mb-4">内容・概要 プレビュー</h2>
                <div class="prose">${contentHTML}</div>
            </body>
            </html>
        `);
            previewWindow.document.close();
        });
    });
</script>
@endsection
