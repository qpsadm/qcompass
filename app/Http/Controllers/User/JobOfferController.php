<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOffer;
use App\Models\Agenda;
use App\Http\Controllers\User\AgendaController as UserAgendaController;

class JobOfferController extends Controller
{
    /**
     * 求人一覧
     */
    public function index(Request $request)
    {
        $query = JobOffer::query()->where('is_show', 1);

        // キーワード検索
        $keyword = trim($request->input('keyword', ''));
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // 表示期間フィルタ（検索中でも表示させたい場合はコメントアウト可）
        $now = now();
        $query->where('start_datetime', '<=', $now)
            ->where('end_datetime', '>=', $now);

        $jobs = $query->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends($request->query());

        // ここで agendas を取得
        $agendas = Agenda::where('category_id', 35)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends($request->query());

        return view('user.job.job_offers_list', compact('jobs', 'agendas'));
    }


    /**
     * 求人詳細
     */
    public function show($id)
    {
        $job = JobOffer::where('id', $id)
            ->where('is_show', 1)
            ->firstOrFail();

        $agendaController = new UserAgendaController();
        $agendas = $agendaController->getAgendasDataByCategoryPaginate(35, 5);

        return view('user.job.job_offers_info', compact('job', 'agendas'));
    }
}
