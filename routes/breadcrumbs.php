<?php

// ここからベタ打ちでパンくず表示するだけのやつ
// Home
// Breadcrumbs::for('home', function ($trail) {
//     $trail->push('Home', route('user.top'));
// });

// // Home > level1 > level2 > ...
// Breadcrumbs::for('under_layer', function ($trail, $under_layers = []) {
//     $trail->parent('home');

//     foreach ($under_layers as $layer) {
//         $trail->push($layer['title'], $layer['route'] ? $layer['route'] : null);
//     }
// });
// ここまでベタ打ちでパンくずを表示するだけのやつ

// use Diglactic\Breadcrumbs\Breadcrumbs;
// use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// // TOP 第1階層
// Breadcrumbs::for('site.top', function (BreadcrumbTrail $trail) {
//     $trail->push('TOPページ', route('site.top'));
// });

// // カテゴリTOP 第2階層
// Breadcrumbs::for('site.category', function (BreadcrumbTrail $trail, Category $category) {
//     $trail->parent('site.top');
//     $trail->push($category->name, route('site.category', $category->id));
// });

// // カテゴリ別記事一覧 第3階層
// Breadcrumbs::for('site.category.article', function (BreadcrumbTrail $trail, Category $category) {
//     $trail->parent('site.category', $category);
//     $trail->push("{$category->name}新着記事一覧", route('site.category.article', $category->id));
// });


use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;
use Illuminate\Support\Str;

/**
 * ルート名から自動パンくず生成
 */
// Breadcrumbs::for('auto-breadcrumbs', function (Trail $trail, $entity = null) {

//     $route = request()->route();
//     $routeName = $route->getName();
//     $routeParams = $route->parameters();

//     if (!$routeName) {
//         return $trail->push('TOP', route('user.top'));
//     }

//     $parts = explode('.', $routeName);

//     if ($routeName === 'user.top') {
//         return $trail->push('TOP', route('user.top'));
//     }

//     //ここから
//     //階層を[.]以外で判断できるようにするマクロらしい（不完全）
//     // Breadcrumbs::macro('autoPrefix', function (BreadcrumbTrail $trail, $routeName, ...$params) {

//     //     // ルート名を分割（例：mypage.reports.show → ["mypage","reports","show"]）
//     //     $parts = preg_split('/[._]/', $routeName);

//     //     // 一段ずつ親を作る
//     //     while (count($parts) > 1) {
//     //         array_pop($parts);
//     //         $parent = implode('.', $parts);   // "mypage.reports"
//     //         $altParent = implode('_', $parts); // "mypage_reports"

//     //         if (Breadcrumbs::exists($parent)) {
//     //             return $trail->parent($parent, ...$params);
//     //         }
//     //         if (Breadcrumbs::exists($altParent)) {
//     //             return $trail->parent($altParent, ...$params);
//     //         }
//     //     }

//     //     return null;
//     // });
//     //ここまで


//     // 1階層目：TOP
//     $trail->push('TOP', route('user.top'));

//     // ラベル変換マップ
//     $labels = [
//         'News_List'      => 'ニュース',
//         'agenda'    => 'アジェンダ',
//         'job'       => '求人票',
//         'reports'   => '日報',
//         'contact'   => 'お問い合わせ',
//         'mypage'    => 'マイページ',
//     ];

//     $currentName = 'user';

//     foreach ($parts as $part) {

//         if ($part === 'user') continue;

//         $label = $labels[$part] ?? Str::headline($part);

//         $currentName .= '.' . $part;

//         if (!Route::has($currentName)) continue;
//         foreach ($routeParams as $key => $value) {

//             // 例：Route::model('course', Course::class); を使っている場合
//             if (is_object($value)) {

//                 // モデルが title や name を持っているならそれをパンくずに
//                 if (property_exists($value, 'title')) {
//                     $label = $value->title;
//                 } elseif (property_exists($value, 'name')) {
//                     $label = $value->name;
//                 }
//             }
//         }

//         $trail->push($label, route($currentName, $routeParams));
//     }
// });

Breadcrumbs::for('auto-breadcrumbs', function (Trail $trail, $entity = null) {

    $route = request()->route();
    $routeName = $route->getName();
    $routeParams = $route->parameters();

    if (!$routeName) {
        return $trail->push('TOP', route('user.top'));
    }

    $parts = explode('.', $routeName);

    if ($routeName === 'user.top') {
        return $trail->push('TOP', route('user.top'));
    }

    $trail->push('TOP', route('user.top'));

    $labels = [
        'news_list'      => 'お知らせ',
        'agendas_list'    => 'アジェンダ',
        'job_offers_list'       => '就職支援',
        'reports_create'   => '日報作成',
        'contact_create'   => 'お問い合わせ',
        'mypage'    => 'マイページ',
    ];

    $currentName = 'user';

    foreach ($parts as $part) {

        if ($part === 'user') continue;

        $label = $labels[$part] ?? Str::headline($part);
        $currentName .= '.' . $part;

        if (!Route::has($currentName)) continue;

        // 🔽 モデルが渡されている場合の処理
        foreach ($routeParams as $key => $value) {

            if (is_object($value)) {

                // Course モデルの場合：親階層を再帰で取得
                if ($value instanceof \App\Models\Course) {

                    $ancestors = [];
                    $parent = $value->parent;

                    // 親がいれば上位から順に追加
                    while ($parent) {
                        array_unshift($ancestors, $parent); // 配列の先頭に追加
                        $parent = $parent->parent;
                    }

                    // 先祖（親コース）を順にパンくずに追加
                    foreach ($ancestors as $ancestor) {
                        $trail->push($ancestor->name, route($currentName, ['course' => $ancestor]));
                    }

                    // 最後に自分自身
                    $label = $value->name;
                }

                // title を持つ他モデルの場合
                elseif (property_exists($value, 'title')) {
                    $label = $value->title;
                } elseif (property_exists($value, 'name')) {
                    $label = $value->name;
                }
            }
        }

        $trail->push($label, route($currentName, $routeParams));
    }
});