<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Theme;
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
        // テーマを取得
        $themes = Theme::where('is_show', 1)->get();


        return view('user.mypage.mypage', compact(
            'user',
            'user_details',
            'pending_diaries',
            'submitted_reports',
            'announcements',
            'courses',       // 講座情報
            'divisions',     // 部署情報
            'themes'
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

    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme_id' => 'required|exists:themes,id',
        ]);

        $user = auth()->user();

        // ユーザー詳細がない場合は作成
        $details = $user->detail ?? $user->detail()->create([]);

        // テーマIDを更新
        $details->theme_id = $request->theme_id;
        $details->save();

        return redirect()->back()->with('success', 'テーマを変更しました。');
    }
    public function updateSettings(Request $request)
    {
        // バリデーション
        $request->validate([
            'fontsize' => 'nullable|integer|min:1|max:3',   // 文字サイズは任意
            'theme_id' => 'nullable|exists:themes,id',       // テーマIDも任意
        ]);

        $user = auth()->user();

        // user_details が存在しない場合は作成
        $details = $user->detail ?? $user->detail()->create([]);

        // 入力値がある場合だけ更新
        if ($request->has('fontsize')) {
            $details->fontsize = $request->fontsize;
        }

        if ($request->has('theme_id')) {
            $details->theme_id = $request->theme_id;
        }

        $details->save();

        return redirect()->back()->with('success', '設定を更新しました。');
    }
}
