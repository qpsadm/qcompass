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