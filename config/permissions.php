<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Sidebar Permissions
    |--------------------------------------------------------------------------
    |
    | role_id
    | 1: 無効
    | 2,3: 一般ユーザー
    | 4: サブ管理者（限定）
    | 5: 制限付き管理者
    | 6,7: 管理者
    | 8: システム管理者
    |
    */

    'sidebar' => [

        // =========================
        // ダッシュボード
        // =========================
        [
            'label' => 'ダッシュボード',
            'icon'  => null,
            'route' => 'admin.dashboard',
            'roles' => [5, 6, 7, 8],
        ],

        // =========================
        // システム管理
        // =========================
        [
            'label' => 'システム管理',
            'icon'  => 'b_system2.svg',
            'roles' => [8],
            'children' => [
                ['label' => '部署',             'route' => 'admin.divisions.index',           'roles' => [8]],
                ['label' => '権限',             'route' => 'admin.roles.index',               'roles' => [8]],
                ['label' => '講座開催者',       'route' => 'admin.organizers.index',          'roles' => [8]],
                ['label' => '講座種類',         'route' => 'admin.levels.index',              'roles' => [8]],
                ['label' => '講座分野',         'route' => 'admin.course_type.index',         'roles' => [8]],
                ['label' => '技術分類タグ',     'route' => 'admin.tags.index',                'roles' => [8]],
                ['label' => 'カテゴリ',         'route' => 'admin.categories.index',          'roles' => [8]],
                ['label' => 'お知らせカテゴリ', 'route' => 'admin.announcement_types.index',  'roles' => [8]],
                ['label' => '今日の一言',       'route' => 'admin.quotes.index',              'roles' => [8]],
            ],
        ],

        // =========================
        // ユーザー管理
        // =========================
        [
            'label' => 'ユーザー管理',
            'icon'  => 'b_user.svg',
            'roles' => [6, 7, 8],
            'children' => [
                ['label' => '受講者一覧', 'route' => 'admin.users.index',           'roles' => [6, 7, 8]],
                ['label' => '社員一覧',   'route' => 'admin.course_teachers.index', 'roles' => [6, 7, 8]],
            ],
        ],

        // =========================
        // 講座管理
        // =========================
        [
            'label' => '講座管理',
            'icon'  => 'b_course.svg',
            'roles' => [5, 6, 7, 8],
            'children' => [
                ['label' => '講座一覧',       'route' => 'admin.courses.index',        'roles' => [5, 6, 7, 8]],
                ['label' => '講座・カテゴリー', 'route' => 'admin.course_category.index', 'roles' => [6, 7, 8]],
                ['label' => '講座・受講者',   'route' => 'admin.course_users.index',   'roles' => [6, 7, 8]],
                ['label' => '日報管理',       'route' => 'admin.reports.index',        'roles' => [5, 6, 7, 8]],
                ['label' => '質疑応答一覧',   'route' => 'admin.questions.index',      'roles' => [5, 6, 7, 8]],
            ],
        ],

        // =========================
        // アジェンダ管理
        // =========================
        [
            'label' => 'アジェンダ管理',
            'icon'  => 'b_agenda.svg',
            'roles' => [5, 6, 7, 8],
            'children' => [
                ['label' => 'アジェンダ一覧', 'route' => 'admin.agendas.index', 'roles' => [5, 6, 7, 8]],
                ['label' => 'アジェンダ登録', 'route' => 'admin.agendas.create', 'roles' => [6, 7, 8]],
            ],
        ],


        // =========================
        // お知らせ管理
        // =========================
        [
            'label' => 'お知らせ管理',
            'icon'  => 'b_information.svg',
            'roles' => [5, 6, 7, 8],
            'children' => [
                ['label' => 'お知らせ一覧', 'route' => 'admin.announcements.index', 'roles' => [5, 6, 7, 8]],
                ['label' => 'お知らせ投稿', 'route' => 'admin.announcements.create', 'roles' => [6, 7, 8]],
            ],
        ],

        // =========================
        // 学習サポート
        // =========================
        [
            'label' => '学習サポート',
            'icon'  => 'b_desk.svg',
            'roles' => [5, 6, 7, 8],
            'children' => [
                ['label' => '学習参考コンテンツ', 'route' => 'admin.learnings.index',      'roles' => [5, 6, 7, 8]],
                ['label' => '就職支援',       'route' => 'admin.job_offers.index',      'roles' => [6, 7, 8]],
            ],
        ],

        // =========================
        // クイズ管理
        // =========================
        [
            'label' => 'クイズ管理',
            'icon'  => 'b_quiz.svg',
            'roles' => [5, 6, 7, 8],
            'children' => [
                ['label' => 'クイズ一覧', 'route' => 'admin.quizzes.index',  'roles' => [5, 6, 7, 8]],
                ['label' => 'クイズ登録', 'route' => 'admin.quizzes.create', 'roles' => [6, 7, 8]],
            ],
        ],

        // =========================
        // ファイル管理
        // =========================
        [
            'label' => 'ファイル一覧',
            'icon'  => 'f_icon_agenda.svg',
            'roles' => [5, 6, 7, 8],
            'children' => [
                ['label' => 'アジェンダファイル一覧', 'route' => 'admin.files.index', 'params' => ['type' => 'agenda'], 'roles' => [5, 6, 7, 8]],
                ['label' => 'お知らせファイル一覧',   'route' => 'admin.files.index', 'params' => ['type' => 'announcement'], 'roles' => [5, 6, 7, 8]],
            ],
        ],

        // =========================
        // その他
        // =========================
        // [
        //     'label' => 'その他',
        //     'icon'  => 'b_system.svg',
        //     'roles' => [7, 8],
        //     'children' => [
        //         ['label' => '実績管理',     'route' => 'admin.achievements.index',         'roles' => [7, 8]],
        //         ['label' => '実績解除管理', 'route' => 'admin.achievements_release.index', 'roles' => [8]],
        //     ],
        // ],

    ],
];
