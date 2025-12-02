<?php
// //ここから自動化用(変換用配列が静的)
// use Diglactic\Breadcrumbs\Breadcrumbs;
// use Diglactic\Breadcrumbs\Generator as Trail;
// use Illuminate\Support\Str;


// /**
//  * 自動パンくず（TOP→親ページ→子ページ）
//  */
// Breadcrumbs::for('auto', function (Trail $trail, $entity = null) {

//     $route = request()->route();
//     $routeName = $route->getName();
//     $routeParams = $route->parameters();

//     // ルート名が取得できなければ TOP だけ
//     if (!$routeName) {
//         return $trail->push('TOP', route('user.top'));
//     }

//     // TOP ページはそれだけで終了
//     if ($routeName === 'user.top') {
//         return $trail->push('TOP', route('user.top'));
//     }

//     // 1階層目：TOP
//     $trail->push('TOP', route('user.top'));

//     // ラベル変換マップ（ルート名 → 表示名）
//     $labels = [
//         'news_list'      => 'お知らせ',
//         'agendas_list'    => 'アジェンダ',
//         'job_offers_list'       => '就職支援',
//         'reports_create'   => '日報作成',
//         'contact_create'   => 'お問い合わせ',
//         'mypage'    => 'マイページ',
//         'questions_list'    => '学習支援',
//     ];

//     // 子ページから親ページルートへのマップ
//     $parentRoutes = [
//         'user.news.news_info'         => 'user.news.news_list',
//         'user.agenda.info'            => 'user.agenda.agendas_list',
//         'user.job.job_offers_info'    => 'user.job.job_offers_list',
//         'user.reports.reports_info'   => 'user.reports',
//     ];

//     $currentName = 'user';
//     $parts = explode('.', $routeName);

//     foreach ($parts as $part) {

//         if ($part === 'user') continue;

//         $label = $labels[$part] ?? Str::headline($part);
//         $currentName .= '.' . $part;

//         if (!Route::has($currentName)) continue;

//         // 🔹 モデルが渡されている場合の処理
//         foreach ($routeParams as $key => $value) {

//             if (is_object($value)) {

//                 // Course モデルの場合：親階層を再帰で取得
//                 if ($value instanceof \App\Models\Course) {

//                     $ancestors = [];
//                     $parent = $value->parent;

//                     while ($parent) {
//                         array_unshift($ancestors, $parent); // 上位から順に
//                         $parent = $parent->parent;
//                     }

//                     foreach ($ancestors as $ancestor) {
//                         $trail->push($ancestor->name, route($currentName, ['course' => $ancestor]));
//                     }

//                     $label = $value->name;
//                 }

//                 // title を持つ他モデル
//                 elseif (property_exists($value, 'title')) {
//                     $label = $value->title;
//                 } elseif (property_exists($value, 'name')) {
//                     $label = $value->name;
//                 }
//             }
//         }

//         // 🔹 親ページルートマップにある場合は先に親を追加
//         if (isset($parentRoutes[$routeName])) {
//             $parentRoute = $parentRoutes[$routeName];

//             $parentParts = explode('.', $parentRoute);
//             $parentLabel = $labels[$parentParts[2]] ?? Str::headline($parentParts[2]);

//             $trail->push($parentLabel, route($parentRoute));
//         }

//         // 現在ページを追加
//         $trail->push($label, route($currentName, $routeParams));
//     }
// });


//ここから自動化用(変換用配列が静的かつコントローラーを使用)
use App\Http\Controllers\User\BreadCrumbsController;
use Illuminate\Support\Str;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;

Breadcrumbs::for('auto', function (Trail $trail, $entity = null) {

    $route = request()->route();
    $routeName = $route->getName();
    $routeParams = $route->parameters();

    if (!$routeName) {
        return $trail->push('TOP', route('user.top'));
    }
    // 子ページから親ページルートへのマップ
    $parentRoutes = [
        'user.news.news_info'         => 'user.news.news_list',
        'user.agenda.info'            => 'user.agenda.agendas_list',
        'user.job.job_offers_info'    => 'user.job.job_offers_list',
        'user.reports.reports_info'   => 'user.reports',
    ];

    $parts = explode('.', $routeName);

    if ($routeName === 'user.top') {
        return $trail->push('TOP', route('user.top'));
    }

    $trail->push('TOP', route('user.top'));


    // 🔽 コントローラーからラベルマップを動的取得
    $labels = BreadCrumbsController::getRouteLabels();

    $currentName = 'user';

    foreach ($parts as $part) {
        if ($part === 'user') continue;

        // ルート名に対応するラベルを取得、なければ自動生成
        $label = $labels[$part] ?? Str::headline($part);

        $currentName .= '.' . $part;

        if (!Route::has($currentName)) continue;




        // モデルパラメータがあれば日本語名で上書き
        foreach ($routeParams as $key => $value) {
            if (is_object($value)) {
                if (property_exists($value, 'title')) {
                    $label = $value->title;
                } elseif (property_exists($value, 'name')) {
                    $label = $value->name;
                }
            }
        }

        // 🔹 親ページルートマップにある場合は先に親を追加
        if (isset($parentRoutes[$routeName])) {
            $parentRoute = $parentRoutes[$routeName];

            $parentParts = explode('.', $parentRoute);
            $parentLabel = $labels[$parentParts[2]] ?? Str::headline($parentParts[2]);

            $trail->push($parentLabel, route($parentRoute));
        }

        // 現在ページを追加
        $trail->push($label, route($currentName, $routeParams));
    }
});