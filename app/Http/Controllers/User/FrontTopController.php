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
        $globalAnnouncements = Announcement::where('status', 2)   // 承認済み
            ->where('is_show', 1)                                  // 表示対象
            ->whereNull('course_id')                                // 訓練校のみ
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
        // 非表示・期間外は除外
        // ----------------------------
        $jobs = JobOffer::where('is_show', 1)              // 表示フラグON
            ->whereNotNull('start_datetime')              // 開始日時あり
            ->whereNotNull('end_datetime')                // 終了日時あり
            ->where('start_datetime', '<=', $now)        // 公開開始済み
            ->where('end_datetime', '>=', $now)          // 公開終了前
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ----------------------------
        // 最新アジェンダ（ユーザーが見れる講座カテゴリのみ）
        // ----------------------------
        $categoryIds = DB::table('course_categories')
            ->whereIn('course_id', $userCourseIds)
            ->where('is_show', 1)
            ->pluck('category_id')
            ->toArray();

        $agendas = collect();
        if (!empty($categoryIds)) {
            $agendas = Agenda::whereIn('category_id', $categoryIds)
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
