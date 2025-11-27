<?php

use Illuminate\Support\Facades\Route;

// =============================
// コントローラー読み込み
// =============================
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CKEditorController;

use App\Http\Controllers\User\UserController as UserUserController; // ← ユーザー用
use App\Http\Controllers\Admin\UserController as AdminUserController; // ← 管理者用
use App\Http\Controllers\User\NewsController;

// 管理画面
use App\Http\Controllers\Admin\{
    AdminDashboardController,
    CourseController,
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
    AchievementController,
    AchievementsReleaseController,
};

// ユーザー向け
use App\Http\Controllers\User\QuizController as UserQuizController;
use App\Http\Controllers\User\AgendaController as UserAgendaController;


// 学習・資格・求人
use App\Http\Controllers\{
    LearningController,
    CertificationController,
    JobOfferController
};

// =============================
// 公開ページ
// =============================
Route::get('/', fn() => view('welcome'));

// =============================
// ダッシュボード（ログイン必須）
// =============================
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return auth()->user()->role_id == 8
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

// =============================
// プロフィール管理
// =============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =============================
// ユーザー用
// =============================
// ユーザー専用ルート
Route::middleware(['auth', 'no-cache'])->prefix('user')->name('user.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('user.dashboard');
    });

    Route::get('dashboard', [NewsController::class, 'dashboard'])->name('dashboard');
    // ニュース一覧
    Route::get('news', [NewsController::class, 'newsListAll'])->name('news.news_list');
    Route::get('news/main', [NewsController::class, 'mainNews'])->name('news.main_news');
    Route::get('news/my', [NewsController::class, 'myNews'])->name('news.my_news');
    //詳細
    Route::get('news/info/{announcement}', [NewsController::class, 'news_info'])
        ->name('news.news_info');

    // 自分の講座アジェンダ一覧
    Route::get('agendas', [UserAgendaController::class, 'myCourseAgendaList'])->name('agendas.my');

    // アジェンダ詳細（必要なら）
    Route::get('agenda/{id}', [UserAgendaController::class, 'agendaDetail'])->name('agenda.detail');
});





// =============================
// 管理画面（role:8 のみアクセス）
// =============================
Route::middleware(['auth', 'role:8', 'redirect.nonuser.dashboard', 'no-cache'])
    ->prefix('admin')->name('admin.')->group(function () {

        // ダッシュボード
        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ユーザー関連
        Route::get('users/trash', [AdminUserController::class, 'trash'])->name('users.trash');
        Route::post('users/{id}/restore', [AdminUserController::class, 'restore'])->name('users.restore');
        Route::delete('users/{id}/forceDelete', [AdminUserController::class, 'forceDelete'])->name('users.forceDelete');

        // 講座ID付き create
        Route::get('course_category/create/{courseId}', [CourseCategoryController::class, 'create'])
            ->name('course_category.create');

        // CKEditor
        Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');

        // =============================
        // アジェンダ・お知らせ共通ファイル管理
        // =============================
        Route::prefix('files')->name('files.')->group(function () {
            // type = agenda / announcement

            // 一覧表示
            Route::get('{type}/{targetId}', [AgendaFileController::class, 'files'])
                ->name('index');

            // 新規作成フォーム
            Route::get('{type}/{targetId}/create', [AgendaFileController::class, 'create'])
                ->name('create');

            // 保存
            Route::post('{type}/{targetId}', [AgendaFileController::class, 'store'])
                ->name('store');

            // プレビュー
            Route::get('{type}/{id}/preview', [AgendaFileController::class, 'preview'])
                ->name('preview');

            // 編集フォーム
            Route::get('{type}/{id}/edit', [AgendaFileController::class, 'edit'])
                ->name('edit');

            // 更新
            Route::put('{type}/{id}', [AgendaFileController::class, 'update'])
                ->name('update');

            // 削除
            Route::delete('{type}/{id}', [AgendaFileController::class, 'destroy'])
                ->name('destroy');
        });
        //講座ごとのアジェンダ一覧
        Route::get('courses/{course}/agendas', [AgendaController::class, 'indexByCourse'])
            ->name('courses.agendas');
        //プレビュー用
        Route::get('agendas/{agenda}/preview', [\App\Http\Controllers\Admin\AgendaController::class, 'preview'])
            ->name('agendas.preview');
        // =============================
        // その他リソース系
        // =============================
        Route::resources([
            'courses' => CourseController::class,
            'users' => AdminUserController::class,
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
            'quizzes' => QuizController::class,
            'learnings' => LearningController::class,
            'certifications' => CertificationController::class,
            'job_offers' => JobOfferController::class,
            'achievements' => AchievementController::class,
            'achievements_release' => AchievementsReleaseController::class,
        ]);

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
        Route::post('reports/preview', [ReportController::class, 'previewBlade'])
            ->name('reports.previewBlade');
        Route::resource('reports', ReportController::class)->where(['report' => '[0-9]+']);
    });

// =============================
// Breeze/Fortify 認証ルート
// =============================
require __DIR__ . '/auth.php';
