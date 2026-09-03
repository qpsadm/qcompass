<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>【QLIP Compass】 - QLIP Programming School</title>

    <style>
        /* 印刷時の最低限のスタイル */
        body {
            font-family: "Helvetica Neue", Arial, "Hiragino Kaku Gothic ProN", "Hiragino Sans", Meiryo, sans-serif;
            margin: 0;
            padding: 20px 40px;
            color: #333;
            background-color: #fff;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            margin: 0 0 1.2rem;
            text-align: center
        }

        h2,
        h3 {
            margin: 0.5rem 0;
        }

        ul {
            padding-left: 1rem;
        }

        .print {
            width: 100%;
            display: flex;
            justify-content: end;
            border-bottom: 1px solid blue;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .btn-print {
            padding: 0.5rem 1rem;
            cursor: pointer;
            background: #2563eb;
            font-size: 16px;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        .btn-print:hover {
            background-color: orange;
        }

        /* 🖨️ 印刷専用スタイル */
        @media print {

            /* 1. 用紙のヘッダー・フッター領域（URLや日付）を消す設定 */
            @page {
                size: A4 portrait;
                /* margin: 0; */
                /* ブラウザ標準のヘッダー・フッター出力領域を削除 */
            }

            /* 2. ボディに余白を設定してコンテンツが見切れないようにする */
            body {
                /* 用紙に合わせて90%に縮小して印刷したい場合 */
                zoom: 90%;

                /* 💡 Mac版Safari等でzoomが効かない場合のフォールバック（CSS transform） */
                -moz-transform: scale(0.9);
                -moz-transform-origin: 0 0;

                padding: 4mm;
                /* @pageのmarginを0にした分、bodyに余白を設定 */
                font-size: 10pt;
                line-height: 1.5;
                color: #000;
                background: #fff;
            }

            /* 3. ブラウザによっては <a> タグのURLを自動挿入するため明示的に打ち消す */
            a[href]::after {
                content: "" !important;
            }

            .container {
                max-width: 100%;
                width: 100%;
                /* margin: 16mm 0; */
                /* padding: 15mm 0; */
            }

            /* 印刷時に非表示にする要素 */
            .no-print {
                display: none !important;
            }

            /* テーブルの印刷最適化 */
            /* table {
                width: 100%;
                border-collapse: collapse;
                page-break-inside: auto;
            }

            th,
            td {
                border: 1px solid #ccc;
                padding: 6px 8px;
            } */

            /* tr,
            blockquote,
            pre,
            .no-break {
                page-break-inside: avoid;
            } */
        }
    </style>
</head>

<body>
    <!-- 画面表示時のみ出す印刷用ボタン（印刷時には自動で消えます） -->
    <div class="container no-print print">
        <button onclick="window.print()" class="btn-print">
            🖨️ 印刷する
        </button>
    </div>

    <div class="container">
        @yield('content')
    </div>
</body>

</html>
