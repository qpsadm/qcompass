export function initAgendaPreview() {
    document.querySelectorAll('.preview-button').forEach(btn => {
        btn.addEventListener('click', function () {
            let contentHTML = this.dataset.content;
            try {
                contentHTML = JSON.parse(contentHTML);
            } catch (e) {
                console.error('JSON parse error', e);
                contentHTML = '';
            }

            const title = this.dataset.title || 'タイトルなし';

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
                    <title>${title} プレビュー</title>
                    <link rel="stylesheet" href="/css/app.css">
                    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
                </head>
                <body class="p-6">
                    <h1 class="text-2xl font-bold mb-2">${title}</h1>
                    <div class="prose">${contentHTML}</div>
                </body>
                </html>
            `);
            previewWindow.document.close();
        });
    });
}
