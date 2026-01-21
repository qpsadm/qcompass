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
            ->whereNull('course_id') // 全体記事のみ
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ----------------------------
        // 現在ログイン中の講座ID
        // ----------------------------
        $userCourseId = session('course_id');

        // ----------------------------
        // 本講座のお知らせ（現在講座のみ）
        // ----------------------------
        $courseAnnouncements = collect();
        if ($userCourseId) {
            $courseAnnouncements = Announcement::where('status', 2)
                ->where('is_show', 1)
                ->where('course_id', $userCourseId) // 本講座のみ
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

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
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        $categoryIds = DB::table('course_categories')
            ->whereIn('course_id', $userCourseIds)
            ->where('is_show', 1)
            ->pluck('category_id')
            ->toArray();

        $excludeCategoryIds = [52, 53]; // 除外カテゴリー

        $agendas = collect();
        if (!empty($categoryIds)) {
            $agendas = Agenda::whereIn('category_id', $categoryIds)
                ->whereNotIn('category_id', $excludeCategoryIds)
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
