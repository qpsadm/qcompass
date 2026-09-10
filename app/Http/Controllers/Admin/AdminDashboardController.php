<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Agenda;
use App\Models\Course;
use App\Models\Announcement;
use App\Models\Report;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ログイン時に保存したセッションから講座IDを取得
        $selectedCourseId = session('course_id');

        // セッションにない場合のフォールバック（管理者等で講座選択なしでログインした場合など）
        if (!$selectedCourseId) {
            $selectedCourseId = $user->myCourses()->first()?->id;
        }

        $today = Carbon::today()->toDateString();

        // 該当コースのカテゴリに紐づくアジェンダを取得（最新10件 カテゴリID昇順 ＞ 作成日時降順）
        $latestAgendas = $selectedCourseId
            ? Agenda::whereHas('category.courses', function ($query) use ($selectedCourseId) {
                $query->where('courses.id', $selectedCourseId)
                    ->where('course_categories.is_show', 1); // 👈 中間テーブルの表示フラグもチェックする場合
            })
            ->with('category')
            // ->orderBy('category_id', 'asc') // 👈 カテゴリIDの昇順
            ->orderBy('updated_at', 'desc')  // 同一カテゴリ内では作成日時の降順
            ->take(10)
            ->get()
            : collect();

        // 該当コースの最新日報を絞り込んで取得
        $latestReports = $selectedCourseId
            ? Report::with(['user', 'course'])
            ->where('course_id', $selectedCourseId)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            : collect(); // $selectedCourseId が null の場合は空のCollectionをセット


        // 最新お知らせの取得（指定コース OR 全体向け(null)）
        $latestAnnouncements = Announcement::with(['type', 'course'])
            ->where(function ($query) use ($selectedCourseId) {
                if ($selectedCourseId) {
                    $query->where('course_id', $selectedCourseId)
                        ->orWhereNull('course_id');
                } else {
                    $query->whereNull('course_id'); // コース未指定時は全体向けのみ
                }
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // 開催中の講座
        $ongoingCourses = Course::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->orderBy('start_date')
            ->get();


        // 受講者一覧（指定コースに所属するユーザー）
        $users = $selectedCourseId
            ? User::query()
            // 1. Blade側で参照するリレーションを一括取得（N+1問題対策）
            ->with(['detail', 'division', 'role', 'courses'])
            // 2. 指定されたコースIDと紐付いているユーザーに絞り込み
            ->whereHas('courses', function ($q) use ($selectedCourseId) {
                $q->where('courses.id', $selectedCourseId);
            })
            // 3. ロールが「受講者（生徒）」のユーザーのみに絞り込む場合（例: role_id = 3）
            // ->where('role_id', 3)
            ->get()
            : collect(); // コース未指定時は空のコレクションを返す

        $users = $selectedCourseId
            ? User::query()
            ->with(['detail', 'division', 'role', 'courses']) // 👈 'division' を追加して N+1 問題を解消
            ->whereHas('courses', function ($q) use ($selectedCourseId) {
                $q->where('courses.id', $selectedCourseId);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            : collect();

        return view('admin.dashboard', compact(
            'ongoingCourses',
            'latestAgendas',
            'latestAnnouncements',
            'latestReports',
            'selectedCourseId',
            'users',
            'today'
        ));
    }
}
