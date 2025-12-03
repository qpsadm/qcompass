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
        $keyword = trim($request->input('keyword', ''));

        $jobsQuery = JobOffer::query()->where('is_show', 1);

        // キーワード検索
        if ($keyword) {
            $jobsQuery->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // ここで表示期間フィルタは任意
        // $now = now();
        // $jobsQuery->where('start_datetime', '<=', $now)
        //     ->where('end_datetime', '>=', $now);

        $jobs = $jobsQuery->orderBy('created_at', 'desc')
            ->paginate(10)   // ページネーション
            ->appends($request->query());

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
        $job = JobOffer::where('id', $id)
            ->where('is_show', 1)
            ->firstOrFail();

        $agendaController = new UserAgendaController();
        $agendas = $agendaController->getAgendasDataByCategoryPaginate(52, 5);

        return view('user.job.job_offers_info', compact('job', 'agendas'));
    }
}
