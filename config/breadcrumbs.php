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
        // 就職支援
        // =============================
        'user.job.job_offers_list' => '就職支援',
        'user.job.job_offers_info' => null, // 個別タイトル

        // =============================
        // 日報
        // =============================
        'user.reports.index'     => '日報一覧',
        'user.reports.create'    => '日報作成',
        'user.reports.info'      => null, // 日報タイトル取得
        'user.reports.confirm'   => '確認',
        'user.reports.complete'  => '完了',

        // =============================
        // お問い合わせ
        // =============================
        'user.contact.create' => 'お問い合わせ',

        // =============================
        // 管理系（必要に応じて）
        // =============================
        'admin.top' => '管理TOP',
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

        // 就職支援
        'user.job.job_offers_info' => 'user.job.job_offers_list',

        // 日報
        'user.reports.info'     => 'user.reports.index',
        'user.reports.create'   => 'user.reports.index',
        'user.reports.confirm'  => 'user.reports.index',
        'user.reports.complete' => 'user.reports.index',
    ],

];
