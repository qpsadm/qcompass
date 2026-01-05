<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;

// =========================
// 自動生成用パンくず
// =========================
Breadcrumbs::for('auto', function (Trail $trail) {

    $route = request()->route();
    $routeName = $route?->getName();
    $params = $route?->parameters() ?? [];

    // TOP
    $trail->push('TOP', route('user.top'));

    if (!$routeName || $routeName === 'user.top') {
        return;
    }

    // 親ルート定義（configで管理）
    $parents = config('breadcrumbs.parents', []);

    if (isset($parents[$routeName])) {
        $parentRoute = $parents[$routeName];
        $trail->push(
            breadcrumb_label($parentRoute, $params),
            route($parentRoute)
        );
    }

    // 現在ページ
    $trail->push(
        breadcrumb_label($routeName, $params),
        route($routeName, $params)
    );
});

// =========================
// パンくず表示名を返す関数
// =========================
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

    // ===== お知らせ詳細 =====
    if ($routeName === 'user.news.news_info') {
        $announcement = request()->route('announcement');
        if ($announcement) {
            return $announcement->title ?? $announcement->name;
        }
    }

    // ===== 日報作成 =====
    if (in_array($routeName, ['user.reports.create', 'user.reports_create'])) {
        return '日報作成';
    }

    // ===== 日報詳細 =====
    if ($routeName === 'user.reports.info') {
        $report = request()->route('report');
        if ($report) {
            return $report->title;
        }
    }

    // ===== 学習支援 / Questions List を固定ラベルにする =====
    if (in_array($routeName, ['user.question.questions_list', 'user.quizzes.index'])) {
        return '学習支援';
    }

    // ===== 設定があれば config/breadcrumbs.php の labels を使用 =====
    $labels = config('breadcrumbs.labels');
    if (isset($labels[$routeName])) {
        return $labels[$routeName];
    }

    // ===== デフォルト =====
    return \Illuminate\Support\Str::headline(
        last(explode('.', $routeName))
    );
}
