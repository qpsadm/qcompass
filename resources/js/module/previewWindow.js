export function initAgendaPreview() {
    const run = () => {
        const previewButton = document.getElementById('preview-button');
        const descriptionHTML = document.getElementById('agenda-description')?.innerHTML ?? '';

        if (!previewButton) {
            console.warn('preview-button not found');
            return;
        }

        previewButton.addEventListener('click', () => {
            const previewWindow = window.open('', 'PreviewWindow', 'width=800,height=600');
            previewWindow.document.write(`
                <html>
                    <head>
                        <title>内容・概要 プレビュー</title>
                        <style>
                            body { font-family: sans-serif; padding: 20px; }
                            .prose { max-width: 65ch; line-height: 1.6; }
                            h1, h2, h3 { margin-top: 1em; }
                            p { margin-bottom: 1em; }
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
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
}
