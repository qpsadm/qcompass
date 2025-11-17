<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserDetailController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DailyQuoteController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;

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
//ユーザー側画面

// 管理画面
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // 各種リソース
    Route::resource('courses', CourseController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('levels', LevelController::class);
    Route::resource('daily_quotes', DailyQuoteController::class);
    Route::resource('organizers', OrganizerController::class);

    // UserDetail（詳細情報）関連ルート
    Route::prefix('users/{user}')->name('user_details.')->group(function () {
        Route::get('details/create', [UserDetailController::class, 'create'])->name('create'); // 詳細情報作成画面
        Route::post('details', [UserDetailController::class, 'store'])->name('store');         // 保存
        Route::get('details/edit', [UserDetailController::class, 'edit'])->name('edit');       // 編集画面
        Route::put('details', [UserDetailController::class, 'update']);                         // 更新
    });

    // カテゴリ管理
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::get('categories-trash', [CategoryController::class, 'trash'])->name('categories.trash');
    Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    // 完全削除
    Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])
        ->name('categories.forceDelete');

    //タグ管理
    Route::resource('tags', App\Http\Controllers\Admin\TagController::class);

    Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');

    //アジェンダ管理
    Route::resource('agendas', AgendaController::class);
    // ゴミ箱一覧
    Route::get('agendas-trash', [AgendaController::class, 'trash'])->name('agendas.trash');
    // 復元
    Route::post('agendas/{id}/restore', [AgendaController::class, 'restore'])->name('agendas.restore');
    // 完全削除（任意）
    Route::delete('agendas/{id}/force-delete', [AgendaController::class, 'forceDelete'])->name('agendas.forceDelete');

    //クイズ関係
    Route::resource('quizzes', QuizController::class);
    Route::resource('questions', QuestionController::class);

    Route::get('quizzes', [QuizController::class, 'listForUser'])
        ->name('quizzes.index');
    Route::get('quizzes/{quiz}', [QuizController::class, 'takeQuiz']);
    Route::post('quizzes/{quiz}/submit', [QuizController::class, 'submitQuiz']);
});

require __DIR__ . '/auth.php';
