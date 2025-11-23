<?php

use Illuminate\Support\Facades\Route;

// =============================
// コントローラー読み込み
// =============================
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CKEditorController;

// 管理画面
use App\Http\Controllers\Admin\{
    AdminDashboardController,
    CourseController,
    UserController,
    RoleController,
    UserDetailController,
    LevelController,
    CategoryController,
    DailyQuoteController,
    OrganizerController,
    TagController,
    AgendaController,
    AgendaFileController,
    QuizController,
    QuizQuestionController,
    CourseTypeController,
    QuoteController,
    QuestionController,
    CourseCategoryController,
    CourseTeacherController,
    AnnouncementController,
    AnnouncementTypeController,
    CourseUserController,
    DivisionController,
    ReportController,
};

// ユーザー向け
use App\Http\Controllers\User\QuizController as UserQuizController;

// 学習・資格・求人
use App\Http\Controllers\{
    LearningController,
    CertificationsController,
    JobOfferController
};

// =============================
// 公開ページ
// =============================
Route::get('/', fn() => view('welcome'));

// =============================
// ダッシュボード（ログイン必須）
// =============================
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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
    Route::get('quizzes/{quiz}', [UserQuizController::class, 'show'])
        ->name('user.quizzes.show');
    Route::post('quizzes/{quiz}/submit', [UserQuizController::class, 'submit'])
        ->name('user.quizzes.submit');
});

// =============================
// 管理画面（role:8 のみアクセス）
// =============================
Route::middleware(['auth', 'role:8'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ダッシュボード
        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ユーザー関連
        Route::get('users/trash', [UserController::class, 'trash'])->name('users.trash');
        Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('users/{id}/forceDelete', [UserController::class, 'forceDelete'])->name('users.forceDelete');

        // リソース系
        Route::resources([
            'courses' => CourseController::class,
            'users' => UserController::class,
            'roles' => RoleController::class,
            'levels' => LevelController::class,
            'daily_quotes' => DailyQuoteController::class,
            'organizers' => OrganizerController::class,
            'questions' => QuestionController::class,
            'course_type' => CourseTypeController::class,
            'quotes' => QuoteController::class,
            'course_teachers' => CourseTeacherController::class,
            'announcements' => AnnouncementController::class,
            'announcement_types' => AnnouncementTypeController::class,
            'divisions' => DivisionController::class,
            'course_category' => CourseCategoryController::class,
            'course_users' => CourseUserController::class,
            'categories' => CategoryController::class,
            'tags' => TagController::class,
            'agendas' => AgendaController::class,
            'agenda_files' => AgendaFileController::class,
            'quizzes' => QuizController::class,
            'learnings' => LearningController::class,
            'certifications' => CertificationsController::class,
            'job_offers' => JobOfferController::class,
        ]);

        // 講座ID付き create
        Route::get('course_category/create/{courseId}', [CourseCategoryController::class, 'create'])
            ->name('course_category.create');

        // 受講生一覧
        Route::get('courses/{course}/students', [CourseController::class, 'students'])
            ->name('courses.students');

        // 講師一覧
        Route::get('courses/{course}/teachers', [CourseController::class, 'getTeachers'])
            ->name('courses.teachers');

        // ユーザー詳細
        Route::prefix('users/{user}')->name('user_details.')->group(function () {
            Route::get('details/create', [UserDetailController::class, 'create'])->name('create');
            Route::post('details', [UserDetailController::class, 'store'])->name('store');
            Route::get('details/{detail}/edit', [UserDetailController::class, 'edit'])->name('edit');
            Route::put('details/{detail}', [UserDetailController::class, 'update'])->name('update');
            Route::delete('details/{detail}', [UserDetailController::class, 'destroy'])->name('destroy');
        });

        // カテゴリのゴミ箱
        Route::get('categories-trash', [CategoryController::class, 'trash'])->name('categories.trash');
        Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

        // CKEditor
        Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');

        // アジェンダ関連
        Route::post('agendas/upload', [AgendaController::class, 'upload'])->name('agendas.upload');
        Route::get('agendas-trash', [AgendaController::class, 'trash'])->name('agendas.trash');
        Route::post('agendas/{id}/restore', [AgendaController::class, 'restore'])->name('agendas.restore');
        Route::delete('agendas/{id}/force-delete', [AgendaController::class, 'forceDelete'])->name('agendas.forceDelete');

        // クイズ関連
        Route::get('quizzes/{quiz}/play', [QuizController::class, 'play'])->name('quizzes.play');
        Route::post('quizzes/{quiz}/play', [QuizController::class, 'submitPlay'])->name('quizzes.submitPlay');
        Route::get('quizzes/result/{attempt}', [QuizController::class, 'result'])->name('quizzes.result');

        // クイズ問題（ネストリソース）
        Route::prefix('quizzes/{quiz}')->name('quizzes.')->group(function () {
            Route::resource('quiz_questions', QuizQuestionController::class);
        });

        // クイズ結果（講座単位）
        Route::get('courses/{course}/results', [App\Http\Controllers\Admin\QuizResultController::class, 'courseResults'])
            ->name('courses.results');

        // レポート関連
        Route::get('reports/preview', [ReportController::class, 'previewBlade'])->name('reports.previewBlade');
        Route::resource('reports', ReportController::class)->where(['report' => '[0-9]+']);
    });

// =============================
// Breeze/Fortify 認証ルート
// =============================
require __DIR__ . '/auth.php';
