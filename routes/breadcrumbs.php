<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Auto Breadcrumb
|--------------------------------------------------------------------------
| 全ルート共通の自動パンくず生成
*/

Breadcrumbs::for('auto', function (Trail $trail) {

    $route = request()->route();
    $routeName = $route?->getName();
    $params = $route?->parameters() ?? [];

    // TOP
    $trail->push('TOP', route('user.top'));

    if (!$routeName || $routeName === 'user.top') {
        return;
    }

    $parents = config('breadcrumbs.parents', []);

    // 親パンくず（安全ガード付き）
    if (isset($parents[$routeName])) {
        $parentRoute = $parents[$routeName];
        $routeObj = app('router')->getRoutes()->getByName($parentRoute);
        $requiredParams = $routeObj?->parameterNames() ?? [];

        $parentParams = array_intersect_key(
            $params,
            array_flip($requiredParams)
        );

        if (count($requiredParams) === count($parentParams)) {
            $trail->push(
                breadcrumb_label($parentRoute, $params),
                route($parentRoute, $parentParams)
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Learning詳細ページならタイプを親に追加
    |--------------------------------------------------------------------------
    */
    if ($routeName === 'user.learnings.learnings_info') {
        $type = $params['type'] ?? request()->query('type') ?? null;
        if ($type) {
            $trail->push(
                breadcrumb_type_label($type),
                route('user.learnings.learnings_by_type', ['type' => $type])
            );
        }
    }

    // 現在ページ
    $trail->push(
        breadcrumb_label($routeName, $params),
        route($routeName, $params)
    );
});


/*
|--------------------------------------------------------------------------
| タイプリストラベル
|--------------------------------------------------------------------------
*/
function breadcrumb_type_label($type)
{
    return match ((int)$type) {
        1 => '参考書籍',
        2 => '参考サイト',
        3 => 'IT資格',
        4 => '制作品',
        default => '学習リソース',
    };
}

/*
|--------------------------------------------------------------------------
| ラベル生成関数
|--------------------------------------------------------------------------
*/
function breadcrumb_label(string $routeName, array $params = [])
{
    // 日報関連
    $dailyReportLabels = [
        'user.reports.create'   => '日報作成',
        'user.reports_create'   => '日報作成',
        'user.reports.confirm'  => '日報作成（確認）',
        'user.reports.complete' => '完了',
    ];

    if (isset($dailyReportLabels[$routeName])) {
        return $dailyReportLabels[$routeName];
    }

    // 日報詳細
    if ($routeName === 'user.reports.info') {
        $report = request()->route('report');
        if ($report?->date) {
            return '日報詳細（' . Carbon::parse($report->date)->format('Y-m-d') . '）';
        }
        return $report->title ?? '日報詳細';
    }

    // Learning タイプ別一覧
    if ($routeName === 'user.learnings.learnings_by_type') {
        $type = $params['type'] ?? null;
        return breadcrumb_type_label($type);
    }

    // Learning詳細
    if ($routeName === 'user.learnings.learnings_info') {
        $learning = request()->route('learning');
        return $learning?->title ?? '学習リソース詳細';
    }

    // アジェンダ詳細
    if ($routeName === 'user.agenda.info') {
        $agenda = request()->route('agenda');
        return $agenda?->agenda_name ?? 'アジェンダ詳細';
    }

    // 求人詳細
    if ($routeName === 'user.job.job_offers_info') {
        $job = request()->route('jobOffer');
        return $job->title ?? $job->name ?? '求人詳細';
    }

    // お知らせ詳細
    if ($routeName === 'user.news.news_info') {
        $announcement = request()->route('announcement');
        return $announcement->title ?? $announcement->name ?? 'お知らせ詳細';
    }

    // クイズ
    if ($routeName === 'user.quizzes.index') {
        return '学習支援';
    }

    // 質疑応答
    if ($routeName === 'user.question.questions_list') {
        return '質疑応答';
    }

    // configラベル
    $labels = config('breadcrumbs.labels', []);
    if (array_key_exists($routeName, $labels)) {
        return $labels[$routeName] ?? '';
    }

    // フォールバック
    return \Illuminate\Support\Str::headline(last(explode('.', $routeName)));
}
