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

        // カテゴリ33のアジェンダ一覧を取得
        $agendaController = new UserAgendaController();
        $agendas = $agendaController->getAgendasDataByCategory(35);

        return view('user.job.job_offers_list', compact('jobs', 'agendas'));
    }

    // 詳細ページ
    public function show($id)
    {
        $job = JobOffer::findOrFail($id);

        // カテゴリ33のアジェンダ一覧取得
        $agendaController = new UserAgendaController();
        $agendas = $agendaController->getAgendasDataByCategory(35); // 「配列だけ返す関数」を用意しておく

        return view('user.job.job_offers_info', compact('job', 'agendas'));
    }
}
