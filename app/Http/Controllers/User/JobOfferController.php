<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\Agenda;
use App\Http\Controllers\User\AgendaController as UserAgendaController;

class JobOfferController extends Controller
{
    // 一覧ページ
    public function index()
    {
        $jobs = JobOffer::paginate(10); // 求人票もページネーション
        $agendas = Agenda::where('category_id', 35)
            ->where('status', 'yes')
            ->where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('user.job.job_offers_list', compact('jobs', 'agendas'));
    }

    // 詳細ページ
    public function show($id)
    {
        $job = JobOffer::findOrFail($id);

        $agendaController = new UserAgendaController();
        $agendas = $agendaController->getAgendasDataByCategoryPaginate(35, 5);

        return view('user.job.job_offers_info', compact('job', 'agendas'));
    }
}
