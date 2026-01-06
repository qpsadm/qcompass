<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminDashboardController,
    UserController as AdminUserController,
    RoleController,
    LevelController,
    DivisionController,
    CourseController,
    CourseTypeController,
    CourseCategoryController,
    CourseTeacherController,
    CourseUserController,
    CategoryController,
    TagController,
    OrganizerController,
    DailyQuoteController,
    QuoteController,
    AgendaController,
    AgendaFileController,
    AnnouncementController,
    AnnouncementTypeController,
    QuestionController,
    QuizController,
    QuizQuestionController,
    ReportController,
    AchievementController,
    AchievementsReleaseController,
    UserDetailController,
    QuizResultController,
};
use App\Http\Controllers\{
    LearningController,
    CertificationController,
    JobOfferController,
};

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'admin',
    'role:4,5,6,7,8',
    'redirect.nonuser.dashboard',
    'no-cache',
])->prefix('admin')->name('admin.')->group(function () {

    /* =============================
     * Dashboard（全管理者）
     * ============================= */
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    /* =============================
     * システム管理（7,8）
     * ============================= */
    Route::middleware('role:7,8')->group(function () {
        Route::resource('divisions', DivisionController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('organizers', OrganizerController::class);
        Route::resource('levels', LevelController::class);
        Route::resource('course_type', CourseTypeController::class);
        Route::resource('course_category', CourseCategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('announcement_types', AnnouncementTypeController::class);
        Route::resource('daily_quotes', DailyQuoteController::class);
        Route::resource('quotes', QuoteController::class);

        Route::get('categories/trash', [CategoryController::class, 'trash'])
            ->name('categories.trash');


        // なりすまし（システム管理者のみ）
        Route::post(
            'users/{user}/impersonate',
            [AdminUserController::class, 'impersonate']
        )->middleware('role:8');
    });


    /* =============================
     * ユーザー管理
     * ============================= */

    // 受講者一覧（5,6,7,8）
    Route::middleware('role:5,6,7,8')->group(function () {
        Route::resource('users', AdminUserController::class);

        Route::get('users/trash', [AdminUserController::class, 'trash'])
            ->name('users.trash');

        // なりすまし開始
        Route::post(
            'users/{user}/impersonate',
            [AdminUserController::class, 'impersonate']
        )->name('users.impersonate');
        // なりすまし解除
        Route::post(
            'users/impersonate/leave',
            [AdminUserController::class, 'leaveImpersonate']
        )->name('users.impersonate.leave');
    });

    // ユーザー詳細（6,7,8）
    Route::middleware('role:6,7,8')->group(function () {
        Route::prefix('users/{user}/details')->name('user_details.')->group(function () {
            Route::get('/create', [UserDetailController::class, 'create'])->name('create');
            Route::post('/', [UserDetailController::class, 'store'])->name('store');
            Route::get('/{detail}/edit', [UserDetailController::class, 'edit'])->name('edit');
            Route::put('/{detail}', [UserDetailController::class, 'update'])->name('update');
            Route::delete('/{detail}', [UserDetailController::class, 'destroy'])->name('destroy');
        });
    });

    /* =============================
     * 講座管理（4,5,6,7,8）
     * ============================= */
    Route::middleware('role:4,5,6,7,8')->group(function () {
        Route::resource('courses', CourseController::class);
        Route::resource('course_teachers', CourseTeacherController::class);
        Route::resource('course_users', CourseUserController::class);
        Route::resource('reports', ReportController::class);
        Route::resource('questions', QuestionController::class);

        Route::get(
            'courses/{course}/students',
            [CourseController::class, 'students']
        )->name('courses.students');

        Route::get(
            'courses/{course}/teachers',
            [CourseController::class, 'getTeachers']
        )->name('courses.teachers');

        Route::get(
            'courses/{course}/results',
            [QuizResultController::class, 'courseResults']
        )->name('courses.results');
    });

    /* =============================
     * アジェンダ管理（4,5,6,7,8）
     * ============================= */
    Route::middleware('role:4,5,6,7,8')->group(function () {
        Route::resource('agendas', AgendaController::class);
        Route::get(
            'courses/{course}/agendas',
            [AgendaController::class, 'indexByCourse']
        )->name('courses.agendas');

        Route::prefix('files')->name('files.')->group(function () {
            Route::get('{type}/{targetId}', [AgendaFileController::class, 'index'])->name('index');
            Route::get('{type}/{targetId}/create', [AgendaFileController::class, 'create'])->name('create');
            Route::post('{type}/{targetId}', [AgendaFileController::class, 'store'])->name('store');
            Route::get('{type}/{id}/preview', [AgendaFileController::class, 'preview'])->name('preview');
            Route::get('{type}/{id}/edit', [AgendaFileController::class, 'edit'])->name('edit');
            Route::put('{type}/{id}', [AgendaFileController::class, 'update'])->name('update');
            Route::delete('{type}/{id}', [AgendaFileController::class, 'destroy'])->name('destroy');
        });
    });

    /* =============================
     * お知らせ管理（6,7,8）
     * ============================= */
    Route::middleware('role:6,7,8')->group(function () {
        Route::resource('announcements', AnnouncementController::class);
    });

    /* =============================
     * 学習サポート（6,7,8）
     * ============================= */
    Route::middleware('role:6,7,8')->group(function () {
        Route::resource('certifications', CertificationController::class);
        Route::resource('learnings', LearningController::class);
        Route::resource('job_offers', JobOfferController::class);
    });

    /* =============================
     * クイズ管理（6,7,8）※保留可
     * ============================= */
    Route::middleware('role:6,7,8')->group(function () {
        Route::resource('quizzes', QuizController::class);
        Route::resource('quizzes.quiz_questions', QuizQuestionController::class);
        Route::get('quizzes/{quiz}/play', [QuizController::class, 'play'])->name('quizzes.play');
    });

    /* =============================
     * 実績管理（6,7,8）※保留
     * ============================= */
    Route::middleware('role:6,7,8')->group(function () {
        Route::resource('achievements', AchievementController::class);
        Route::resource('achievements_release', AchievementsReleaseController::class);
    });
});
