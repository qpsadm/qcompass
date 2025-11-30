<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Http\Controllers\User\AgendaController as UserAgendaController;

class JobOfferController extends Controller
{
    // 一覧ページ
    public function index()
    {
        $jobs = JobOffer::all();

        $agendaController = new UserAgendaController();
        // ページネーション対応（10件ごと）
        $agendas = $agendaController->getAgendasDataByCategoryPaginate(35, 10);

        return view('user.job.job_offers_list', compact('jobs', 'agendas'));
    }

    // 詳細ページ
    public function show($id)
    {
        $job = JobOffer::findOrFail($id);

        $agendaController = new UserAgendaController();
        $agendas = $agendaController->getAgendasDataByCategoryPaginate(35, 10);

        return view('user.job.job_offers_info', compact('job', 'agendas'));
    }
}
