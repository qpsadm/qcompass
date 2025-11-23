<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Agenda;
use App\Models\Course;
use App\Models\Report; // ← 追加

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 最新5件のアジェンダ
        $latestAgendas = Agenda::orderBy('id', 'desc')->take(5)->get();

        // 最新5件のお知らせ
        $latestAnnouncements = Announcement::orderBy('id', 'desc')->take(5)->get();

        // 開催中の講座
        $today = now()->format('Y-m-d');
        $ongoingCourses = Course::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->get();

        // 最新5件の日報（ユーザー名・講座名も取得）
        $latestReports = Report::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'latestAnnouncements',
            'latestAgendas',
            'ongoingCourses',
            'latestReports' // ← 追加
        ));
    }
}
