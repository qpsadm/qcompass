<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserDetailController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DailyQuoteController;


// 公開ページ
Route::get('/', function () {
    return view('welcome');
});

// ダッシュボード
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// プロフィール管理
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 管理画面
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // 各種リソース
    Route::resource('courses', CourseController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('levels', LevelController::class);
    Route::resource('daily_quotes', DailyQuoteController::class);

    // UserDetail（詳細情報）関連ルート
    Route::prefix('users/{user}')->name('user_details.')->group(function () {
        Route::get('details/create', [UserDetailController::class, 'create'])->name('create'); // 詳細情報作成画面
        Route::post('details', [UserDetailController::class, 'store'])->name('store');         // 保存
        Route::get('details/edit', [UserDetailController::class, 'edit'])->name('edit');       // 編集画面
        Route::put('details', [UserDetailController::class, 'update']);                         // 更新
    });

    // カテゴリ管理
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::put('/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    });
});

require __DIR__ . '/auth.php';