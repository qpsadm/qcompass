<?php

use Illuminate\Support\Facades\Route;

// 公開トップ
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('user.top');
    }
    return redirect()->route('login');
});

// ルート分割
require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
