<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\Admin\{
    AdminDashboardController,
    CourseController,
    RoleController,
    UserController,
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

Route::middleware([
    'auth',
    'admin',
    'redirect.nonuser.dashboard',
    'no-cache',
    'check.crud.course_teacher'
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])
            ->name('ckeditor.upload');

        Route::resources([
            'courses' => CourseController::class,
            'users' => UserController::class,
            'categories' => CategoryController::class,
            'agendas' => AgendaController::class,
            'quizzes' => QuizController::class,
            'announcements' => AnnouncementController::class,
            'announcement_types' => AnnouncementTypeController::class,
            'course_category' => CourseCategoryController::class,
            'course_teachers' => CourseTeacherController::class,
            'course_users' => CourseUserController::class,
            'tags' => TagController::class,
            'quotes' => QuoteController::class,
            'questions' => QuestionController::class,
            'daily_quotes' => DailyQuoteController::class,
            'organizers' => OrganizerController::class,
            'achievements' => AchievementController::class,
            'achievements_release' => AchievementsReleaseController::class,
        ]);

        Route::middleware('admin.strict')->group(function () {
            Route::resource('roles', RoleController::class);
            Route::resource('levels', LevelController::class);
            Route::resource('divisions', DivisionController::class);
            Route::resource('course_type', CourseTypeController::class);
        });
    });
