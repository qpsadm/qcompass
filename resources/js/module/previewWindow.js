export function initAgendaPreview() {
    const previewButton = document.getElementById('preview-button');

    if (!previewButton) {
        console.warn('preview-button not found');
        return;
    }

    previewButton.addEventListener('click', () => {
        const descriptionHTML = document.getElementById('agenda-description')?.innerHTML ?? '';

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
                    <!-- ✅ 必要なCSSを読み込む -->
                    <link rel="stylesheet" href="/css/app.css">
                    <link rel="stylesheet" href="public/assets/css/test.css">
                    <!-- Tailwindを使っているなら以下も追加 -->
                    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet"> -->
                </head>
                <body>
                    <h2 class="text-xl font-bold mb-4">内容・概要 プレビュー</h2>
                    <div class="prose">${descriptionHTML}</div>
                </body>
            </html>
        `);
        previewWindow.document.close();
    });
}
