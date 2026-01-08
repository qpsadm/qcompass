<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Course;
use App\Models\Announcement;
use App\Models\Report;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // 開催中の講座
        $ongoingCourses = Course::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->orderBy('start_date')
            ->get();

        // 最新アジェンダ（作成日時が新しい5件）
        $latestAgendas = Agenda::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 最新お知らせ
        $latestAnnouncements = Announcement::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 最新日報
        $latestReports = Report::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'ongoingCourses',
            'latestAgendas',
            'latestAnnouncements',
            'latestReports'
        ));
    }
}
