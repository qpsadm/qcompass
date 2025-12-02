<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/f_variable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/f_common.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body>
    <div class="login-container">

        <div class="login-form-container">
            <div class="site-logo">
                <img src="{{ asset('assets/images/logo_star.svg') }}" alt="ロゴ">
            </div>

            {{ $slot }}

        </div>

        <img src="{{ asset('assets/images/test/github_icon.png') }}" alt="icon_1" class="random_arrange"
            style="top:10%; left:20%;">
        <img src="{{ asset('assets/images/test/apple_icon.png') }}" alt="icon_2" class="random_arrange"
            style="top:28%; left:2%;">
        <img src="{{ asset('assets/images/test/illustrator_icon.png') }}" alt="icon_3" class="random_arrange"
            style="top:48%; left:15%;">
        <img src="{{ asset('assets/images/test/js_icon.png') }}" alt="icon_4" class="random_arrange"
            style="top:30%; left:29%;">
        <img src="{{ asset('assets/images/test/windows_icon.png') }}" alt="icon_5" class="random_arrange"
            style="top:3%; left:65%;">
        <img src="{{ asset('assets/images/test/photoshop_icon.png') }}" alt="icon_6" class="random_arrange"
            style="top:25%; left:77%;">
        <img src="{{ asset('assets/images/test/php_icon.png') }}" alt="icon_7" class="random_arrange"
            style="top:3%; left:85%;">
        <img src="{{ asset('assets/images/test/vscode_icon.png') }}" alt="icon_8" class="random_arrange"
            style="top:42%; left:90%;">
        <img src="{{ asset('assets/images/test/laravel_icon.png') }}" alt="icon_9" class="random_arrange"
            style="top:50%; left:70%;">
        <img src="{{ asset('assets/images/test/html_icon.png') }}" alt="icon_10" class="random_arrange"
            style="top:70%; left:77%;">
        <img src="{{ asset('assets/images/test/codepen_icon.png') }}" alt="icon_11" class="random_arrange"
            style="top:2%; left:5%;">



    </div>
</body>

</html>
