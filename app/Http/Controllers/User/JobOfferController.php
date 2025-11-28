<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\JobOffer;


class JobOfferController extends Controller
{
    // 一覧ページ
    public function index()
    {
        $jobs = JobOffer::all();
        return view('user.job.job_offers_list', compact('jobs'));
    }


    // 詳細ページ
    public function show($id)
    {
        $job = JobOffer::findOrFail($id);
        return view('user.job.job_offers_info', compact('job'));
    }
}