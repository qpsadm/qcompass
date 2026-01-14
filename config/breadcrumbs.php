<?php

return [

    /*
    |--------------------------------------------------------------------------
    | パンくず表示名マップ
    |--------------------------------------------------------------------------
    |
    | キー   : ルート名
    | 値     : パンくずに表示する日本語名
    |
    | ※ null にすると動的タイトルを取得する
    |
    */

    'labels' => [

        // 共通
        'user.top' => 'TOP',
        'user.mypage' => 'マイページ',

        // =============================
        // お知らせ
        // =============================
        'user.news.news_list'   => 'お知らせ',
        'user.news.news_info'   => null, // 個別タイトル取得
        'user.news.main_news'   => 'お知らせ（全体）',
        'user.news.my_news'     => 'お知らせ（本講座）',
        'user.news.news_create' => 'お知らせ作成',
        'user.news.news_edit'   => 'お知らせ編集',

        // =============================
        // アジェンダ
        // =============================
        'user.agenda.agendas_list' => 'アジェンダ',
        'user.agenda.info'         => null, // 個別タイトル取得
        'user.agenda.create'       => 'アジェンダ作成',
        'user.agenda.edit'         => 'アジェンダ編集',

        // =============================
        // 学習支援 / クイズ
        // =============================
        'user.quizzes.index' => '学習支援',
        'user.quizzes.show'  => null, // 動的タイトル
        'user.quizzes.result' => '結果',

        // =============================
        // 質疑応答
        // =============================
        'user.question.questions_list' => '質疑応答',
        'user.question.questions_detail' => null, // 個別タイトル取得（あれば）

        // =============================
        // 就職支援
        // =============================
        'user.job.job_offers_list' => '就職支援',
        'user.job.job_offers_info' => null, // 個別タイトル
        'user.job.job_dl_info' => '履歴書・職務経歴書のテンプレート', // 個別タイトル
        // =============================
        // 日報
        // =============================
        'user.reports.index'     => '日報一覧',
        'user.reports.create'    => '日報作成',
        'user.reports_create'    => '日報作成',
        'user.reports.confirm'   => '日報作成（確認）',
        'user.reports.complete'  => '完了',
        'user.reports.info'      => null, // 日報タイトル（日付）取得

        // =============================
        // お問い合わせ
        // =============================
        'user.contact.create' => 'お問い合わせ',

        // =============================
        // 管理系（必要に応じて）
        // =============================
        'admin.top' => '管理TOP',
        'user.about' => '本サイトについて',
        'user.download' => 'ダウンロード',
        'user.teacher.teachers_list' => '講師紹介',
        'user.teacher.teachers_info' => '講師詳細',
        'user.course.courses_info' => '講座紹介',
        'user.privacy' => '利用規約・プライバシーポリシー'
    ],

    /*
    |--------------------------------------------------------------------------
    | 親ルート定義
    |--------------------------------------------------------------------------
    |
    | 詳細・編集画面のときだけ親を明示的に指定
    | 最低限だけ定義
    |
    */
    'parents' => [

        // お知らせ
        'user.news.news_info'   => 'user.news.news_list',
        'user.news.news_edit'   => 'user.news.news_list',

        // アジェンダ
        'user.agenda.info'      => 'user.agenda.agendas_list',
        'user.agenda.edit'      => 'user.agenda.agendas_list',

        // 学習支援
        'user.quizzes.show'     => 'user.quizzes.index',

        // 質疑応答
        'user.question.questions_detail' => 'user.question.questions_list',

        // 就職支援
        'user.job.job_offers_info' => 'user.job.job_offers_list',

        // 日報
        'user.reports.create'   => 'user.mypage',
        'user.reports_create'   => 'user.mypage',
        'user.reports.confirm'  => 'user.mypage',
        'user.reports.info'     => 'user.mypage',
        'user.reports.complete' => 'user.mypage',

        //講師紹介
        'user.teacher.teachers_list' =>  'user.teacher.teachers_info'
    ],

];
