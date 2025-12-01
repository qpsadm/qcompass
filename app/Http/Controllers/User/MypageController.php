<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_details = $user->detail;

        // 未提出日報
        $pending_diaries = $this->getPendingDiaries($user);

        // 提出済み日報（日付ごとに最新1件のみ）
        $submitted_reports = $user->reports
            ->sortByDesc('date')     // 日付順にソート
            ->unique('date')         // 日付ごとにユニーク
            ->values()               // インデックスを詰める
            ->map(function ($report) {
                $report->url = route('user.reports_info', ['report' => $report->id]);
                return $report;
            });

        // お知らせ
        $announcements = Announcement::latest()->take(5)->get();
        $courses = $user->myCourses;
        $divisions = $user->division;

        return view('user.mypage.mypage', compact(
            'user',
            'user_details',
            'pending_diaries',
            'submitted_reports',
            'announcements',
            'courses',       // 講座情報
            'divisions'     // 部署情報
        ));
    }

    private function getPendingDiaries($user)
    {
        $courses = $user->myCourses()->get();
        $pending = [];

        foreach ($courses as $course) {
            $start = \Carbon\Carbon::parse($course->start_date);
            $end   = \Carbon\Carbon::parse($course->end_date);

            $period = new \DatePeriod(
                $start,
                new \DateInterval('P1D'),
                $end->copy()->addDay()
            );

            foreach ($period as $date) {
                $exists = $user->reports()
                    ->where('course_id', $course->id)
                    ->whereDate('date', $date)
                    ->exists();

                if (!$exists) {
                    $diary = new \stdClass();
                    $diary->date = $date->format('Y-m-d');
                    $diary->course_id = $course->id;
                    $diary->course_name = $course->course_name;
                    // 日報作成URL
                    $diary->url = route('user.reports_create', [
                        'course_id' => $course->id,
                        'date' => $date->format('Y-m-d')
                    ]);

                    $pending[] = $diary;
                }
            }
        }

        // 日付でユニークにして、同じ日が複数講座でも1件だけに
        $pending = collect($pending)->unique('date')->values()->all();

        return $pending;
    }

    public function updateFontsize(Request $request)
    {
        $request->validate([
            'fontsize' => 'required|integer|min:1|max:3', // 任意の範囲
        ]);

        $user = auth()->user();

        // user_details が存在しない場合は作成
        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            ['fontsize' => $request->fontsize]
        );

        return redirect()->back()->with('success', '文字サイズを更新しました');
    }
}
