<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOffer;
use App\Models\Agenda;
use Carbon\Carbon;
use App\Http\Controllers\User\AgendaController as UserAgendaController;

class JobOfferController extends Controller
{
    /**
     * 求人一覧
     */
    public function index(Request $request)
    {
        $keyword = trim($request->input('keyword', ''));
        $now = now(); // Carbonインスタンスのまま比較

        $jobsQuery = JobOffer::query()
            ->where('is_show', 1)
            ->whereNotNull('start_datetime')  // 開始日が設定されている
            ->whereNotNull('end_datetime')    // 終了日が設定されている
            ->where('start_datetime', '<=', $now)  // 公開開始済み
            ->where('end_datetime', '>=', $now);   // 公開終了前

        // キーワード検索
        if ($keyword) {
            $jobsQuery->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // ページネーション
        $jobs = $jobsQuery->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends($request->query());

        // おまけで Agenda も取得
        $agendas = Agenda::where('category_id', 52)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('user.job.job_offers_list', compact('jobs', 'agendas'));
    }

    /**
     * 求人詳細
     */
    public function show($id)
    {
        $now = now();

        $job = JobOffer::where('id', $id)
            ->where('is_show', 1)
            ->whereNotNull('start_datetime')
            ->whereNotNull('end_datetime')
            ->where('start_datetime', '<=', $now)
            ->where('end_datetime', '>=', $now)
            ->firstOrFail();

        // 前後の求人取得
        $prevJob = JobOffer::where('id', '<', $job->id)
            ->where('is_show', 1)
            ->whereNotNull('start_datetime')
            ->whereNotNull('end_datetime')
            ->where('start_datetime', '<=', $now)
            ->where('end_datetime', '>=', $now)
            ->orderBy('id', 'desc')
            ->first();

        $nextJob = JobOffer::where('id', '>', $job->id)
            ->where('is_show', 1)
            ->whereNotNull('start_datetime')
            ->whereNotNull('end_datetime')
            ->where('start_datetime', '<=', $now)
            ->where('end_datetime', '>=', $now)
            ->orderBy('id')
            ->first();

        // カテゴリ52のアジェンダ取得
        $agendaController = new UserAgendaController();
        $agendas = $agendaController->getAgendasDataByCategoryPaginate(52, 5);

        return view('user.job.job_offers_info', compact('job', 'agendas', 'prevJob', 'nextJob'));
    }
}
