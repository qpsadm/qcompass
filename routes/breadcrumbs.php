<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;
use Carbon\Carbon;

Breadcrumbs::for('auto', function (Trail $trail) {

    $route = request()->route();
    $routeName = $route?->getName();
    $params = $route?->parameters() ?? [];

    // TOP
    $trail->push('TOP', route('user.top'));

    if (!$routeName || $routeName === 'user.top') return;

    $parents = config('breadcrumbs.parents', []);

    if (isset($parents[$routeName])) {
        $parentRoute = $parents[$routeName];
        $trail->push(
            breadcrumb_label($parentRoute, $params),
            route($parentRoute)
        );
    }

    $trail->push(
        breadcrumb_label($routeName, $params),
        route($routeName, $params)
    );
});

function breadcrumb_label(string $routeName, array $params = [])
{
    // 日報関連ラベル
    $dailyReportLabels = [
        'user.reports.create'   => '日報作成',
        'user.reports_create'   => '日報作成',
        'user.reports.confirm'  => '日報作成（確認）',
        'user.reports.complete' => '完了',
    ];

    if (isset($dailyReportLabels[$routeName])) {
        return $dailyReportLabels[$routeName];
    }

    if ($routeName === 'user.reports.info') {
        $report = request()->route('report');
        if ($report && $report->date) {
            return "日報詳細（" . Carbon::parse($report->date)->format('Y-m-d') . "）";
        }
        return $report->title ?? '日報詳細';
    }

    // アジェンダ詳細
    if ($routeName === 'user.agenda.info') {
        $agenda = request()->route('agenda');
        if ($agenda) return $agenda->agenda_name;
    }

    // 求人詳細
    if ($routeName === 'user.job.job_offers_info') {
        $job = request()->route('jobOffer');
        if ($job) return $job->title ?? $job->name;
    }

    // お知らせ詳細
    if ($routeName === 'user.news.news_info') {
        $announcement = request()->route('announcement');
        if ($announcement) return $announcement->title ?? $announcement->name;
    }

    // 学習支援
    if (in_array($routeName, ['user.question.questions_list', 'user.quizzes.index'])) {
        return '学習支援';
    }

    $labels = config('breadcrumbs.labels');
    if (isset($labels[$routeName]) && $labels[$routeName] !== null) {
        return $labels[$routeName];
    }

    return \Illuminate\Support\Str::headline(last(explode('.', $routeName)));
}
