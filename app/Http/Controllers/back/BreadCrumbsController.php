<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class BreadCrumbsController extends Controller
{
    /**
     * ルート名 → 日本語ラベル のマップを動的に生成
     */
    public static function getRouteLabels(): array
    {
        // ここで配列を生成（DBや設定ファイルから読み込むことも可能）
        // この配列が翻訳表になっている
        $labels = [
            'news_list' => '新着情報一覧',
            'news_info' => '新着情報詳細',
            'main_news' => '訓練に関するお知らせ',
            'my_news' => '講座に関するお知らせ',
            'agendas_list' => 'アジェンダ一覧',
            'info' => 'アジェンダ詳細', //agendas_infoのこと
            'job_offers_list' => '就職支援',
            'job_offers_info' => '求人情報',
            'job_dl_info' => '履歴書等ダウンロード一覧',
            'job_dl_list' => '履歴書等ダウンロード詳細',
            'contact_create' => 'お問い合わせ',
            'mypage' => 'マイページ',
            'reports_create' => '日報作成',
            'reports_confirm' => '日報確認',
            'reports_info' => '日報詳細',
            'reports_complete' => '日報送信完了',
            'questions_list' => '質疑応答一覧',
            'questions_info' => '質疑応答詳細',
            'courses_info' => '講座情報',

        ];

        // 子ページから親ページルートへのマップ
        $parentRoutes = [
            'user.news.news_info'         => 'user.news.news_list',
            'user.agenda.info'            => 'user.agenda.agendas_list',
            'user.job.job_offers_info'    => 'user.job.job_offers_list',
            'user.reports.reports_info'   => 'user.reports',
        ];
        // 必要であれば DB から取得して追加することも可能
        // 例：Category::pluck('name', 'slug')->toArray();

        return $labels;
    }
}
