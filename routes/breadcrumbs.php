<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Auto Breadcrumb
|--------------------------------------------------------------------------
| 全ルート共通パンくず
| ・学習支援は「仮想ノード（非リンク）」
| ・クイズ / Learning は正しい階層＆リンク
*/

Breadcrumbs::for('auto', function (Trail $trail) {

    $route     = request()->route();
    $routeName = $route?->getName();
    $params    = $route?->parameters() ?? [];

    /*
    |----------------------------------------------------------------------
    | TOP
    |----------------------------------------------------------------------
    */
    $trail->push('TOP', route('user.top'));

    if (!$routeName || $routeName === 'user.top') {
        return;
    }

    /*
    |----------------------------------------------------------------------
    | 学習支援（仮想ノード・非リンク）
    |----------------------------------------------------------------------
    */
    if (
        str_starts_with($routeName, 'user.quizzes.')
        || str_starts_with($routeName, 'user.learnings.')
    ) {
        $trail->push('学習支援');
    }

    /*
    |----------------------------------------------------------------------
    | 一覧ページ
    |----------------------------------------------------------------------
    */

    // クイズ一覧
    if ($routeName === 'user.quizzes.index') {
        $trail->push('クイズ');
        return;
    }

    // Learning タイプ別一覧
    if ($routeName === 'user.learnings.learnings_by_type') {

        $type = $params['type'] ?? null;

        $trail->push(
            breadcrumb_type_label($type),
            route('user.learnings.learnings_by_type', ['type' => $type])
        );

        return;
    }

    /*
    |----------------------------------------------------------------------
    | クイズ詳細 / 結果
    |----------------------------------------------------------------------
    */
    if (str_starts_with($routeName, 'user.quizzes.')) {

        // クイズ一覧（リンクあり）
        $trail->push('クイズ', route('user.quizzes.index'));

        // クイズ詳細
        if ($routeName === 'user.quizzes.show') {
            $quiz = request()->route('quiz');
            $trail->push($quiz?->title ?? 'クイズ詳細');
            return;
        }

        // クイズ結果
        if ($routeName === 'user.quizzes.result') {
            $trail->push('結果');
            return;
        }
    }

    /*
    |----------------------------------------------------------------------
    | Learning 詳細
    |----------------------------------------------------------------------
    */
    if ($routeName === 'user.learnings.learnings_info') {

        $learning = request()->route('learning');

        $type = $params['type']
            ?? request()->query('type')
            ?? $learning?->type;

        // タイプ別一覧（リンクあり）
        if ($type) {
            $trail->push(
                breadcrumb_type_label($type),
                route('user.learnings.learnings_by_type', ['type' => $type])
            );
        }

        // 詳細（非リンク）
        $trail->push($learning?->title ?? '学習リソース詳細');
        return;
    }

    /*
    |----------------------------------------------------------------------
    | その他（config/breadcrumbs.php ベース）
    |----------------------------------------------------------------------
    */
    $label = breadcrumb_label($routeName, $params);
    if ($label !== '') {
        $trail->push($label);
    }
});


/*
|----------------------------------------------------------------------
| タイプ別ラベル
|----------------------------------------------------------------------
*/
function breadcrumb_type_label($type)
{
    return match ((int)$type) {
        1 => '参考書籍',
        2 => '参考サイト',
        3 => 'IT資格',
        4 => '制作品紹介',
        default => '学習リソース',
    };
}


/*
|----------------------------------------------------------------------
| ラベル解決
|----------------------------------------------------------------------
*/
function breadcrumb_label(string $routeName, array $params = [])
{
    // 日報詳細
    if ($routeName === 'user.reports.info') {
        $report = request()->route('report');
        return $report?->date
            ? '日報詳細（' . Carbon::parse($report->date)->format('Y-m-d') . '）'
            : '日報詳細';
    }

    // アジェンダ
    if ($routeName === 'user.agenda.info') {
        return request()->route('agenda')?->agenda_name ?? 'アジェンダ詳細';
    }

    // 求人
    if ($routeName === 'user.job.job_offers_info') {
        return request()->route('jobOffer')?->title ?? '求人詳細';
    }

    // お知らせ
    if ($routeName === 'user.news.news_info') {
        return request()->route('announcement')?->title ?? 'お知らせ詳細';
    }

    // config/breadcrumbs.php
    $labels = config('breadcrumbs.labels', []);
    return $labels[$routeName] ?? '';
}
