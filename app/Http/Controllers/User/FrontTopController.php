<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Announcement;
use App\Models\JobOffer;
use App\Models\Agenda;

use App\Http\Controllers\User\QuoteController as UserQuoteController;

class FrontTopController extends Controller
{
    /**
     * トップページ表示
     */
    public function index()
    {
        $userId = Auth::id();

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
        // ----------------------------
        $jobs = JobOffer::latest()
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

        // 今日の一言
        $todayQuote = UserQuoteController::todayQuote();

        // 現在の表示モード
        $quote_mode = session('quote_mode', 'full');

        return view('user.top', compact(
            'globalAnnouncements',
            'courseAnnouncements',
            'jobs',
            'agendas',
            'todayQuote',
            'quote_mode'
        ));
    }
}
