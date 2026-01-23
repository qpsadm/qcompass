<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
| 認証後ユーザー向け画面
| URL prefix: /user
| Route name: user.*
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\User\{
    FrontTopController,
    NewsController,
    AgendaController as UserAgendaController,
    QuizController as UserQuizController,
    QuestionController as UserQuestionController,
    JobOfferController as UserJobOfferController,
    ReportController as UserReportController,
    ContactController as UserContactController,
    QuoteController as UserQuoteController,
    MypageController,
    MyCourseController,
    TeacherController,
    LearningController,
};

Route::middleware(['auth', 'no-cache'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Top
        |--------------------------------------------------------------------------
        */
        Route::get('/', fn() => redirect()->route('user.top'));
        Route::get('/top', [FrontTopController::class, 'index'])->name('top');

        /*
        |--------------------------------------------------------------------------
        | News
        |--------------------------------------------------------------------------
        */
        Route::prefix('news')->name('news.')->group(function () {
            Route::get('/', [NewsController::class, 'newsListAll'])->name('news_list');
            Route::get('/main', [NewsController::class, 'mainNews'])->name('main_news');
            Route::get('/my', [NewsController::class, 'myNews'])->name('my_news');
            Route::get('/info/{announcement}', [NewsController::class, 'news_info'])
                ->name('news_info');
        });

        /*
        |--------------------------------------------------------------------------
        | Agenda
        |--------------------------------------------------------------------------
        */
        Route::prefix('agendas')->name('agenda.')->group(function () {
            Route::get('/', [UserAgendaController::class, 'myCourseAgendaList'])
                ->name('agendas_list');

            Route::get('/category/{category_id}', [UserAgendaController::class, 'agendaByCategory'])
                ->name('agenda_by_category');

            Route::get('/{agenda}', [UserAgendaController::class, 'agendaDetail'])
                ->name('info');
        });

        /*
        |--------------------------------------------------------------------------
        | Questions
        |--------------------------------------------------------------------------
        */
        Route::get('questions/{category?}', [UserQuestionController::class, 'index'])
            ->name('question.questions_list');

        /*
        |--------------------------------------------------------------------------
        | Job Offers
        |--------------------------------------------------------------------------
        */
        Route::prefix('job')->name('job.')->group(function () {

            Route::get('/', [UserJobOfferController::class, 'index'])
                ->name('job_offers_list');

            // ✅ 固定パス・詳細パスを先に
            Route::get('/dl/{agenda}', [UserAgendaController::class, 'jobDlInfo'])
                ->name('job_dl_info');

            // ✅ 最後に catch-all
            Route::get('/{jobOffer}', [UserJobOfferController::class, 'show'])
                ->whereNumber('jobOffer')
                ->name('job_offers_info');
        });


        Route::get('/download/{agenda}', [UserAgendaController::class, 'download'])
            ->name('download');

        /*
        |--------------------------------------------------------------------------
        | Reports（日報）
        |--------------------------------------------------------------------------
        */
        Route::prefix('reports')->name('reports.')->group(function () {

            // 一覧ページ（パンくず用ラベル）
            Route::get('/', [UserReportController::class, 'index'])->name('index');

            // 日報作成 → 先に固定ルートを置く
            Route::get('/create', [UserReportController::class, 'create'])->name('create');

            // POST系（確認・保存）
            Route::post('/', [UserReportController::class, 'store'])->name('store');
            Route::post('/confirm', [UserReportController::class, 'confirm'])->name('confirm');
            Route::get('/complete', [UserReportController::class, 'complete'])->name('complete');

            // 日報詳細 → 必ず最後に
            Route::get('/{report}', [UserReportController::class, 'show'])
                ->whereNumber('report') // 数字だけマッチ
                ->name('info');
        });


        /*
        |--------------------------------------------------------------------------
        | ★ 互換用エイリアス（超重要）
        |--------------------------------------------------------------------------
        | 既存 Blade の route('user.reports_create') を壊さない
        */
        Route::get('reports/create', [UserReportController::class, 'create'])
            ->name('reports_create');

        /*
        |--------------------------------------------------------------------------
        | Contact
        |--------------------------------------------------------------------------
        */
        Route::prefix('contact')->name('contact.')->group(function () {
            Route::get('/create', [UserContactController::class, 'create'])
                ->name('create');

            Route::post('/', [UserContactController::class, 'store'])
                ->name('store');

            Route::post('/confirm', [UserContactController::class, 'confirm'])
                ->name('confirm');

            Route::get('/complete', [UserContactController::class, 'complete'])
                ->name('complete');
        });

        /*
        |--------------------------------------------------------------------------
        | Quote
        |--------------------------------------------------------------------------
        */
        Route::post('/quote_mode', [UserQuoteController::class, 'toggleMode'])
            ->name('quote_mode');

        /*
        |--------------------------------------------------------------------------
        | MyPage
        |--------------------------------------------------------------------------
        */
        Route::prefix('mypage')->group(function () {
            Route::get('/', [MypageController::class, 'index'])->name('mypage');
            Route::post('/settings/update', [MypageController::class, 'updateSettings'])
                ->name('settings.update');
            Route::post('/memo/save', [MypageController::class, 'saveMemo'])
                ->name('memo.save');
            Route::post('/avatar-type', [MypageController::class, 'updateAvatarType'])
                ->name('avatar_type');
        });

        /*
        |--------------------------------------------------------------------------
        | learnings
        |--------------------------------------------------------------------------
        */
        Route::prefix('learnings')->name('learnings.')->group(function () {
            Route::get('/', [LearningController::class, 'index'])->name('learnings_list');
            Route::get('/type/{type}', [LearningController::class, 'byType'])->name('learnings_by_type');
            Route::get('/learnings_info/{learning}', [LearningController::class, 'show'])->name('learnings_info');
        });


        /*
        |--------------------------------------------------------------------------
        | Courses / Teachers
        |--------------------------------------------------------------------------
        */
        Route::get('/courses', [MyCourseController::class, 'index'])
            ->name('course.courses_info');

        Route::prefix('teachers')->name('teacher.')->group(function () {
            Route::get('/', [TeacherController::class, 'index'])
                ->name('teachers_list');

            Route::get('/{teacher}', [TeacherController::class, 'show'])
                ->whereNumber('teacher')
                ->name('teachers_info');
        });

        /*
        |--------------------------------------------------------------------------
        | Static
        |--------------------------------------------------------------------------
        */
        Route::view('/about', 'user.about')->name('about');
        Route::view('/privacy', 'user.privacy')->name('privacy');
        Route::view('/rule', 'user.rule')->name('rule');

        /*
|--------------------------------------------------------------------------
| Quiz（講座 → カテゴリ → クイズ）
|--------------------------------------------------------------------------
*/
        Route::prefix('quizzes')->name('quizzes.')->group(function () {
            Route::get('/', [UserQuizController::class, 'index'])
                ->name('index');

            // クイズ表示
            Route::get('/{quiz}', [UserQuizController::class, 'show'])
                ->whereNumber('quiz')
                ->name('show');

            // 回答送信
            Route::post('/{quiz}/submit', [UserQuizController::class, 'submit'])
                ->whereNumber('quiz')
                ->name('submit');

            // 結果表示（DB保存なし）
            Route::get('/{quiz}/result', [UserQuizController::class, 'result'])
                ->whereNumber('quiz')
                ->name('result');
        });
    });
