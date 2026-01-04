<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| 管理画面
| URL prefix: /admin
| Route name: admin.*
|--------------------------------------------------------------------------
*/

// =============================
// Controller Imports
// =============================
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\admin\{
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
};
use App\Http\Controllers\{
    LearningController,
    CertificationController,
    JobOfferController,
};
use App\Http\Controllers\admin\QuizResultController;

// =============================
// Admin Route Group
// =============================
Route::middleware([
    'auth',
    'admin',
    'redirect.nonuser.dashboard',
    'no-cache',
    'check.crud.course_teacher',
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // =============================
        // Dashboard
        // =============================
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // =============================
        // Impersonate（なりすまし）
        // =============================
        Route::post('/users/{user}/impersonate', [AdminUserController::class, 'impersonate'])
            ->name('users.impersonate');

        Route::post('/impersonate/leave', [AdminUserController::class, 'leaveImpersonate'])
            ->name('users.impersonate.leave');

        // =============================
        // Users
        // =============================
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/trash', [AdminUserController::class, 'trash'])->name('trash');
            Route::post('/{id}/restore', [AdminUserController::class, 'restore'])->name('restore');
            Route::delete('/{id}/forceDelete', [AdminUserController::class, 'forceDelete'])->name('forceDelete');
        });

        Route::resource('users', AdminUserController::class);

        // =============================
        // User Details（ネスト）
        // =============================
        Route::prefix('users/{user}/details')->name('user_details.')->group(function () {
            Route::get('/create', [UserDetailController::class, 'create'])->name('create');
            Route::post('/', [UserDetailController::class, 'store'])->name('store');
            Route::get('/{detail}/edit', [UserDetailController::class, 'edit'])->name('edit');
            Route::put('/{detail}', [UserDetailController::class, 'update'])->name('update');
            Route::delete('/{detail}', [UserDetailController::class, 'destroy'])->name('destroy');
        });

        // =============================
        // CKEditor
        // =============================
        Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])
            ->name('ckeditor.upload');

        // =============================
        // Files（Agenda / Announcement 共通）
        // =============================
        Route::prefix('files')->name('files.')->group(function () {
            Route::get('{type}/{targetId}', [AgendaFileController::class, 'files'])->name('index');
            Route::get('{type}/{targetId}/create', [AgendaFileController::class, 'create'])->name('create');
            Route::post('{type}/{targetId}', [AgendaFileController::class, 'store'])->name('store');
            Route::get('{type}/{id}/preview', [AgendaFileController::class, 'preview'])->name('preview');
            Route::get('{type}/{id}/edit', [AgendaFileController::class, 'edit'])->name('edit');
            Route::put('{type}/{id}', [AgendaFileController::class, 'update'])->name('update');
            Route::delete('{type}/{id}', [AgendaFileController::class, 'destroy'])->name('destroy');
        });

        // =============================
        // Courses
        // =============================
        Route::get('courses/{course}/students', [CourseController::class, 'students'])
            ->name('courses.students');

        Route::get('courses/{course}/teachers', [CourseController::class, 'getTeachers'])
            ->name('courses.teachers');

        Route::get('courses/{course}/agendas', [AgendaController::class, 'indexByCourse'])
            ->name('courses.agendas');

        Route::get('courses/{course}/results', [QuizResultController::class, 'courseResults'])
            ->name('courses.results');

        Route::resource('courses', CourseController::class);

        // =============================
        // Agenda
        // =============================
        Route::get('agendas-trash', [AgendaController::class, 'trash'])->name('agendas.trash');
        Route::post('agendas/{id}/restore', [AgendaController::class, 'restore'])->name('agendas.restore');
        Route::delete('agendas/{id}/force-delete', [AgendaController::class, 'forceDelete'])->name('agendas.forceDelete');
        Route::post('agendas/upload', [AgendaController::class, 'upload'])->name('agendas.upload');
        Route::get('agendas/{agenda}/preview', [AgendaController::class, 'preview'])->name('agendas.preview');

        Route::resource('agendas', AgendaController::class);

        // =============================
        // Category
        // =============================
        Route::get('categories-trash', [CategoryController::class, 'trash'])->name('categories.trash');
        Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

        Route::resource('categories', CategoryController::class);

        // =============================
        // Quiz
        // =============================
        Route::get('quizzes/{quiz}/play', [QuizController::class, 'play'])->name('quizzes.play');
        Route::post('quizzes/{quiz}/play', [QuizController::class, 'submitPlay'])->name('quizzes.submitPlay');
        Route::get('quizzes/result/{attempt}', [QuizController::class, 'result'])->name('quizzes.result');

        Route::prefix('quizzes/{quiz}')->name('quizzes.')->group(function () {
            Route::resource('quiz_questions', QuizQuestionController::class);
        });

        Route::resource('quizzes', QuizController::class);

        // =============================
        // Report
        // =============================
        Route::match(['get', 'post'], 'reports/preview', [ReportController::class, 'previewBlade'])
            ->name('reports.previewBlade');

        Route::resource('reports', ReportController::class)->where(['report' => '[0-9]+']);

        // =============================
        // Others（通常管理）
        // =============================
        Route::resources([
            'organizers' => OrganizerController::class,
            'tags' => TagController::class,
            'questions' => QuestionController::class,
            'announcements' => AnnouncementController::class,
            'announcement_types' => AnnouncementTypeController::class,
            'daily_quotes' => DailyQuoteController::class,
            'quotes' => QuoteController::class,
            'course_teachers' => CourseTeacherController::class,
            'course_users' => CourseUserController::class,
            'course_category' => CourseCategoryController::class,
            'learnings' => LearningController::class,
            'certifications' => CertificationController::class,
            'job_offers' => JobOfferController::class,
            'achievements' => AchievementController::class,
            'achievements_release' => AchievementsReleaseController::class,
        ]);

        // =============================
        // Strict Admin Only
        // =============================
        Route::middleware('admin.strict')->group(function () {
            Route::resource('roles', RoleController::class);
            Route::resource('levels', LevelController::class);
            Route::resource('divisions', DivisionController::class);
            Route::resource('course_type', CourseTypeController::class);
        });

        // =============================
        // Quote Toggle
        // =============================
        Route::get('quotes/toggle-mode/{quote}', [QuoteController::class, 'toggleMode'])
            ->name('quotes.toggleMode');
    });
