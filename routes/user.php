<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController as UserUserController;
use App\Http\Controllers\User\NewsController;
use App\Http\Controllers\User\QuizController as UserQuizController;
use App\Http\Controllers\User\AgendaController as UserAgendaController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\QuestionController as UserQuestionController;
use App\Http\Controllers\User\JobOfferController as UserJobOfferController;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\User\ContactController as UserContactController;
use App\Http\Controllers\User\FrontTopController;
use App\Http\Controllers\User\QuoteController as UserQuoteController;
use App\Http\Controllers\User\MypageController;
use App\Http\Controllers\User\MyCourseController;
use App\Http\Controllers\User\TeacherController;

Route::middleware(['auth', 'no-cache'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/', fn() => redirect()->route('user.top'));

        Route::get('top', [FrontTopController::class, 'index'])->name('top');

        // ニュース
        Route::get('news', [NewsController::class, 'newsListAll'])->name('news.news_list');
        Route::get('news/main', [NewsController::class, 'mainNews'])->name('news.main_news');
        Route::get('news/my', [NewsController::class, 'myNews'])->name('news.my_news');
        Route::get('news/info/{announcement}', [NewsController::class, 'news_info'])
            ->name('news.news_info');

        // アジェンダ
        Route::get('agendas', [UserAgendaController::class, 'myCourseAgendaList'])
            ->name('agenda.agendas_list');

        Route::get('agendas/category/{category_id}', [UserAgendaController::class, 'agendaByCategory'])
            ->name('agenda.agenda_by_category');

        Route::get('agenda/{id}', [UserAgendaController::class, 'agendaDetail'])
            ->name('agenda.info');

        // 質疑
        Route::get('questions/{category?}', [UserQuestionController::class, 'index'])
            ->name('question.questions_list');

        // 求人
        Route::get('job', [UserJobOfferController::class, 'index'])->name('job.job_offers_list');
        Route::get('job/{id}', [UserJobOfferController::class, 'show'])->name('job.job_offers_info');

        // ダウンロード
        Route::get('download/{id}', [UserAgendaController::class, 'download'])->name('download');

        // 日報
        Route::get('reports/create', [UserReportController::class, 'create'])->name('reports_create');
        Route::post('reports', [UserReportController::class, 'store'])->name('reports_store');
        Route::post('reports/confirm', [UserReportController::class, 'confirm'])->name('reports_confirm');
        Route::get('reports/complete', [UserReportController::class, 'complete'])->name('reports_complete');
        Route::get('reports/{report}', [UserReportController::class, 'show'])->name('reports_info');

        // 問い合わせ
        Route::get('contact/create', [UserContactController::class, 'create'])->name('contact_create');
        Route::post('contact', [UserContactController::class, 'store'])->name('contact_store');
        Route::post('contact/confirm', [UserContactController::class, 'confirm'])->name('contact_confirm');
        Route::get('contact/complete', [UserContactController::class, 'complete'])->name('contact_complete');

        // マイページ
        Route::get('mypage', [MypageController::class, 'index'])->name('mypage');

        // 講座・講師
        Route::get('courses', [MyCourseController::class, 'index'])->name('course.courses_info');
        Route::get('teachers', [TeacherController::class, 'index'])->name('teacher.teachers_list');
        Route::get('teachers/{teacher}', [TeacherController::class, 'show'])
            ->name('teacher.teachers_info');

        // クイズ
        Route::get('quizzes', [UserQuizController::class, 'index'])->name('quizzes.index');
        Route::get('quizzes/{quiz}', [UserQuizController::class, 'show'])->name('quizzes.show');
        Route::post('quizzes/{quiz}/submit', [UserQuizController::class, 'submit'])->name('quizzes.submit');
        Route::get('quizzes/{quiz}/result', [UserQuizController::class, 'result'])->name('quizzes.result');

        // 今日の一言（表示切り替え）
        Route::post('quote_mode', [UserQuoteController::class, 'toggleMode'])
            ->name('quote_mode');
    });
