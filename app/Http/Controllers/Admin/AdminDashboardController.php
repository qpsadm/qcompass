<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Agenda;
use App\Models\Course;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 最新5件のアジェンダを取得
        $latestAgendas = Agenda::orderBy('id', 'desc')->take(5)->get();

        // 既存のお知らせも取得
        $latestAnnouncements = Announcement::orderBy('id', 'desc')->take(5)->get();

        // 開催中の講座（今日の日付でフィルター）
        $today = now()->format('Y-m-d');
        $ongoingCourses = Course::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->get();

        // Blade に渡す
        return view(
            'admin.dashboard',
            compact('latestAnnouncements', 'latestAgendas', 'ongoingCourses')
        );
    }
}
