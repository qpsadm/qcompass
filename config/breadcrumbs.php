<?php

return [

    /*
    |--------------------------------------------------------------------------
    | パンくず表示名マップ
    |--------------------------------------------------------------------------
    */
    'labels' => [

        // =============================
        // 共通
        // =============================
        'user.top'    => 'TOP',
        'user.mypage' => 'マイページ',

        // =============================
        // お知らせ
        // =============================
        'user.news.news_list' => 'お知らせ',
        'user.news.news_info' => null,
        'user.news.main_news' => 'お知らせ（全体）',
        'user.news.my_news'   => 'お知らせ（本講座）',

        // =============================
        // アジェンダ
        // =============================
        'user.agenda.agendas_list' => 'アジェンダ',
        'user.agenda.info'         => null,

        // =============================
        // 学習支援（仮想カテゴリ）
        // =============================
        // ※ 実ページは quizzes.index
        'user.quizzes.index' => 'クイズ',

        // --- クイズ ---
        'user.quizzes.show'   => null,   // クイズタイトル
        'user.quizzes.result' => '結果',

        // --- Learning ---
        'user.learnings.learnings_by_type' => null, // 参考書籍 / IT資格 等
        'user.learnings.learnings_info'    => null, // 学習タイトル

        // =============================
        // 質疑応答
        // =============================
        'user.question.questions_list' => '質疑応答',

        // =============================
        // 就職支援
        // =============================
        'user.job.job_offers_list' => '就職支援',
        'user.job.job_offers_info' => null,
        'user.job.job_dl_info'     => '履歴書・職務経歴書テンプレート',

        // =============================
        // 日報
        // =============================
        'user.reports.index'    => '日報一覧',
        'user.reports.create'   => '日報作成',
        'user.reports_create'   => '日報作成',
        'user.reports.confirm'  => '日報作成（確認）',
        'user.reports.complete' => '完了',
        'user.reports.info'     => null,

        // =============================
        // その他
        // =============================
        'user.contact.create' => 'お問い合わせ',
        'user.about'          => '本サイトについて',
        'user.privacy'        => '利用規約・プライバシーポリシー',

        'user.teacher.teachers_list' => '講師紹介',
        'user.teacher.teachers_info' => '講師詳細',
        'user.course.courses_info'   => '講座紹介',
    ],

    /*
    |--------------------------------------------------------------------------
    | 親ルート定義
    |--------------------------------------------------------------------------
    */
    'parents' => [

        // =============================
        // お知らせ
        // =============================
        'user.news.news_info' => 'user.news.news_list',

        // =============================
        // アジェンダ
        // =============================
        'user.agenda.info' => 'user.agenda.agendas_list',

        // =============================
        // 学習支援
        // =============================

        // クイズ
        'user.quizzes.show'   => 'user.quizzes.index',
        'user.quizzes.result' => 'user.quizzes.show',

        // Learning
        'user.learnings.learnings_by_type' => 'user.quizzes.index',
        'user.learnings.learnings_info'    => 'user.learnings.learnings_by_type',

        // =============================
        // 質疑応答
        // =============================
        'user.question.questions_list' => 'user.quizzes.index',

        // =============================
        // 就職支援
        // =============================
        'user.job.job_offers_info' => 'user.job.job_offers_list',

        // =============================
        // 日報
        // =============================
        'user.reports.create'   => 'user.mypage',
        'user.reports_create'   => 'user.mypage',
        'user.reports.confirm'  => 'user.mypage',
        'user.reports.complete' => 'user.mypage',
        'user.reports.info'     => 'user.mypage',
    ],
];
