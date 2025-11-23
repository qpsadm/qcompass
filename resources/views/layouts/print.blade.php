<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>印刷用プレビュー</title>
    <style>
        /* 印刷時の最低限のスタイル */
        body {
            font-family: sans-serif;
            margin: 1rem;
        }

        h1,
        h2,
        h3 {
            margin: 0.5rem 0;
        }

        ul {
            padding-left: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
