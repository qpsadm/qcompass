<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // ログインユーザーの報告だけを取得
        $reports = Report::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get();

        return view('user.mypage.reports_info', compact('reports'));
    }
}
