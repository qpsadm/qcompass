<?php

use Illuminate\Support\Facades\Route;

// コントローラー読み込み
use App\Http\Controllers\ProfileController;
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
use App\Http\Controllers\Admin\QuizQuestionController;
use App\Http\Controllers\Admin\CourseTypeController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseTeacherController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AnnouncementTypeController;
use App\Http\Controllers\Admin\CourseUserController;
use App\Http\Controllers\LearningController;



// =============================
// 公開ページ
// =============================
Route::get('/', function () {
    return view('welcome');
});

// =============================
// ダッシュボード（ログイン必須）
// =============================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =============================
// プロフィール管理
// =============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =============================
// ユーザー用クイズ画面（一般ユーザー）
// =============================
Route::middleware('auth')->group(function () {
    Route::get('quizzes/{quiz}', [App\Http\Controllers\User\QuizController::class, 'show'])
        ->name('user.quizzes.show');
    Route::post('quizzes/{quiz}/submit', [App\Http\Controllers\User\QuizController::class, 'submit'])
        ->name('user.quizzes.submit');
});

// =============================
// 管理画面（role:8 のみアクセス）
// =============================
Route::middleware(['auth', 'role:8'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ---------- リソース系 ----------
        Route::resource('courses', CourseController::class);
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('levels', LevelController::class);
        Route::resource('daily_quotes', DailyQuoteController::class);
        Route::resource('organizers', OrganizerController::class);
        Route::resource('questions', QuestionController::class);
        Route::resource('course_type', CourseTypeController::class);
        Route::resource('quotes', QuoteController::class);

        Route::resource('course_teachers', CourseTeacherController::class);
        Route::resource('announcements', AnnouncementController::class);
        Route::resource('announcement_types', AnnouncementTypeController::class);

        // 講座ID付き create を定義（resource より前）
        Route::get(
            'course_category/create/{courseId}',
            [CourseCategoryController::class, 'create']
        )
            ->name('course_category.create');

        // 既存の resource
        Route::resource('course_category', CourseCategoryController::class);
        Route::resource('course_users', CourseUserController::class);

        // ---------- ユーザー詳細 ----------
        Route::prefix('users/{user}')
            ->name('user_details.')
            ->group(function () {
                Route::get('details/create', [UserDetailController::class, 'create'])->name('create');
                Route::post('details', [UserDetailController::class, 'store'])->name('store');
                Route::get('details/{detail}/edit', [UserDetailController::class, 'edit'])->name('edit');
                Route::put('details/{detail}', [UserDetailController::class, 'update'])->name('update');
                Route::delete('details/{detail}', [UserDetailController::class, 'destroy'])->name('destroy');
            });

        // ---------- カテゴリ ----------
        Route::resource('categories', CategoryController::class);
        Route::get('categories-trash', [CategoryController::class, 'trash'])->name('categories.trash');
        Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])
            ->name('categories.forceDelete');

        // ---------- タグ ----------
        Route::resource('tags', TagController::class);

        // ---------- CKEditor ----------
        Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');

        // ---------- アジェンダ ----------
        Route::resource('agendas', AgendaController::class);
        Route::post('agendas/upload', [AgendaController::class, 'upload'])->name('agendas.upload');
        Route::resource('agenda_files', App\Http\Controllers\Admin\AgendaFileController::class);
        Route::get('agendas-trash', [AgendaController::class, 'trash'])->name('agendas.trash');
        Route::post('agendas/{id}/restore', [AgendaController::class, 'restore'])->name('agendas.restore');
        Route::delete('agendas/{id}/force-delete', [AgendaController::class, 'forceDelete'])
            ->name('agendas.forceDelete');

        // ---------- クイズ ----------
        Route::resource('quizzes', QuizController::class);

        // ★重複削除済み：ここだけでOK
        Route::resource('quizzes.quiz_questions', QuizQuestionController::class);

        // ---------- レポート ----------
        // プレビュー（固定）
        Route::get('reports/preview', [ReportController::class, 'previewBlade'])
            ->name('reports.previewBlade');

        // 重複を完全削除し、これだけ残す
        Route::resource('reports', ReportController::class)
            ->where(['report' => '[0-9]+']);

        // ---------- 学習コンテンツの部分 ----------

        Route::middleware(['auth'])->group(function () {
            Route::resource('learnings', LearningController::class);
        });
    });


// =============================
// Breeze/Fortify 認証ルート
// =============================
require __DIR__ . '/auth.php';