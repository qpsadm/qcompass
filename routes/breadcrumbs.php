<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;
use Illuminate\Support\Str;

Breadcrumbs::for('auto', function (Trail $trail) {

    $route = request()->route();
    $routeName = $route?->getName();
    $params = $route?->parameters() ?? [];

    // ----------------------
    // TOP
    // ----------------------
    $trail->push('TOP', route('user.top'));

    if (!$routeName || $routeName === 'user.top') {
        return;
    }

    // ----------------------
    // 親ルート定義（詳細・編集用）
    // ----------------------
    $parents = [
        // ニュース
        'user.news.news_info'    => 'user.news.news_list',
        'user.news.news_edit'    => 'user.news.news_list',
        'user.news.news_create'  => 'user.news.news_list',

        // アジェンダ
        'user.agenda.info'       => 'user.agenda.agendas_list',
        'user.agenda.edit'       => 'user.agenda.agendas_list',
        'user.agenda.create'     => 'user.agenda.agendas_list',

        // 就職支援 / 求人
        'user.job.job_offers_info' => 'user.job.job_offers_list',

        // 日報
        'user.reports.reports_info' => 'user.reports',
    ];

    // 親があるなら先に追加
    if (isset($parents[$routeName])) {
        $parent = $parents[$routeName];
        $trail->push(
            breadcrumb_label($parent),
            route($parent)
        );
    }

    // ----------------------
    // 現在ページ
    // ----------------------
    $trail->push(
        breadcrumb_label($routeName, $params),
        route($routeName, $params)
    );
});

/**
 * パンくず用のラベル取得
 */
function breadcrumb_label(string $routeName, array $params = [])
{
    // ===== アジェンダ詳細 =====
    if ($routeName === 'user.agenda.info') {
        $agenda = request()->route('agenda');
        if ($agenda) {
            return $agenda->agenda_name;
        }
    }

    // ===== 求人詳細 =====
    if ($routeName === 'user.job.job_offers_info') {
        $job = request()->route('jobOffer');
        if ($job) {
            return $job->title ?? $job->name;
        }
    }

    // ===== 日報詳細 =====
    if ($routeName === 'user.reports.reports_info') {
        $report = request()->route('report');
        if ($report) {
            return $report->title ?? $report->name;
        }
    }

    // 設定があれば config/breadcrumbs.php の labels を参照
    $labels = config('breadcrumbs.labels', []);
    if (isset($labels[$routeName])) {
        return $labels[$routeName];
    }

    // デフォルト：ルート名の末尾を見やすく変換
    return Str::headline(last(explode('.', $routeName)));
}
