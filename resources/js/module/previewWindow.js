export function initAgendaPreview() {
    const previewButton = document.getElementById('preview-button');
    const descriptionHTML = document.getElementById('agenda-description')?.innerHTML ?? '';

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
                <style>
                    body {
                        font-family: sans-serif;
                        padding: 20px;
                        background: #fff;
                        color: #000;
                    }
                    .prose {
                        max-width: 65ch;
                        line-height: 1.75;
                        font-size: 1rem;
                    }
                    h1, h2, h3 {
                        margin-top: 1.5em;
                        margin-bottom: 0.5em;
                    }
                    p {
                        margin-bottom: 1em;
                    }
                    blockquote {
                        border-left: 4px solid #ccc;
                        padding-left: 1em;
                        color: #555;
                        margin: 1em 0;
                        background-color: #f9f9f9;
                    }
                    ol {
                        padding-left: 1.5em;
                    }
                    li {
                        margin-bottom: 0.5em;
                    }
                </style>
            </head>
            <body>
                <h2>内容・概要 プレビュー</h2>
                <div class="prose">${descriptionHTML}</div>
            </body>
        </html>
    `);
        previewWindow.document.close();
    });
}
