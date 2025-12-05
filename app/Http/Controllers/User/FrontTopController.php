<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Announcement;
use App\Models\JobOffer;
use App\Models\Agenda;
use Carbon\Carbon;

class FrontTopController extends Controller
{
    /**
     * トップページ表示
     */
    public function index()
    {
        $userId = Auth::id();
        $now = Carbon::now();

        // ----------------------------
        // 全体のお知らせ（訓練校）
        // ----------------------------
        $globalAnnouncements = Announcement::where('status', 2)
            ->where('is_show', 1)
            ->whereNull('course_id')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ----------------------------
        // 自分の講座のお知らせ
        // ----------------------------
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        $courseAnnouncements = Announcement::where('status', 2)
            ->where('is_show', 1)
            ->whereIn('course_id', $userCourseIds)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ----------------------------
        // 求人情報（最新5件）
        // ----------------------------
        $jobs = JobOffer::where('is_show', 1)
            ->whereNotNull('start_datetime')
            ->whereNotNull('end_datetime')
            ->where('start_datetime', '<=', $now)
            ->where('end_datetime', '>=', $now)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ----------------------------
        // 最新アジェンダ
        // ----------------------------
        $categoryIds = DB::table('course_categories')
            ->whereIn('course_id', $userCourseIds)
            ->where('is_show', 1)
            ->pluck('category_id')
            ->toArray();

        $excludeCategoryIds = [52, 53]; // ← 追加

        $agendas = collect();
        if (!empty($categoryIds)) {
            $agendas = Agenda::whereIn('category_id', $categoryIds)
                ->whereNotIn('category_id', $excludeCategoryIds) // ← これで除外！
                ->where('status', 'yes')
                ->where('is_show', 1)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }


        // ----------------------------
        // Blade に渡す
        // ----------------------------
        return view('user.top', compact(
            'globalAnnouncements',
            'courseAnnouncements',
            'jobs',
            'agendas'
        ));
    }
}
