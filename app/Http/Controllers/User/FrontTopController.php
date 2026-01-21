<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\JobOffer;
use App\Models\Agenda;
use Carbon\Carbon;

class FrontTopController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // なりすまし中のユーザーか判定
        $isImpersonating = session()->has('impersonator_id');

        // 表示対象ユーザー
        $viewUser = $isImpersonating
            ? \App\Models\User::find(session('impersonator_id'))
            : Auth::user();

        if (!$viewUser) abort(403, 'ユーザーが見つかりません');

        // ----------------------------
        // 1. 全体お知らせ
        // ----------------------------
        $globalAnnouncements = Announcement::where('status', 2)
            ->where('is_show', 1)
            ->whereNull('course_id')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ----------------------------
        // 2. 本講座ID（セッション優先）
        // ----------------------------
        $userCourseId = $isImpersonating
            ? session('impersonator_course_id') ?? $viewUser->courses()->first()?->id
            : session('course_id') ?? $viewUser->courses()->first()?->id;

        // ----------------------------
        // 3. 本講座お知らせ
        // ----------------------------
        $courseAnnouncements = collect();
        if ($userCourseId) {
            $courseAnnouncements = Announcement::where('status', 2)
                ->where('is_show', 1)
                ->where('course_id', $userCourseId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // ----------------------------
        // 4. 求人情報
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
        // 5. 最新アジェンダ（本講座のみ）
        // ----------------------------
        $categoryIds = \DB::table('course_categories')
            ->where('course_id', $userCourseId)
            ->where('is_show', 1)
            ->pluck('category_id')
            ->toArray();

        $excludeCategoryIds = [52, 53];

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
        // 6. Blade に渡す
        // ----------------------------
        return view('user.top', compact(
            'globalAnnouncements',
            'courseAnnouncements',
            'jobs',
            'agendas'
        ));
    }
}
