<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Theme;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DatePeriod;
use DateInterval;

class MypageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_details = $user->detail;

        /*
        |--------------------------------------------------------------------------
        | 表示用講座の決定
        |--------------------------------------------------------------------------
        | 優先順位
        | 1. なりすまし講座（session）
        | 2. ユーザー自身の講座
        */

        $impersonateCourseId = session('impersonator_course_id');

        if ($impersonateCourseId) {
            // なりすまし中
            $courses = Course::where('id', $impersonateCourseId)->get();
        } else {
            // 通常
            $courses = $user->myCourses;
        }

        $courseIds = $courses->pluck('id')->toArray();

        /*
        |--------------------------------------------------------------------------
        | 未提出日報（表示用講座基準）
        |--------------------------------------------------------------------------
        */
        $pending_diaries = $this->getPendingDiariesByCourses($user, $courses);

        /*
        |--------------------------------------------------------------------------
        | 提出済み日報（日付ごとに最新1件）
        |--------------------------------------------------------------------------
        */
        $submitted_reports = $user->reports()
            ->whereIn('course_id', $courseIds)
            ->orderByDesc('date')
            ->get()
            ->unique('date')
            ->values()
            ->map(function ($report) {
                $report->url = route('user.reports.info', ['report' => $report->id]);
                return $report;
            });

        /*
        |--------------------------------------------------------------------------
        | 各種スケジュール（type_id = 7）
        |--------------------------------------------------------------------------
        */
        $currentCourseId = session('course_id'); // 現在ログイン中の講座ID

        $scheduledAnnouncements = Announcement::where('type_id', 7)
            ->where('is_show', 1)
            ->where('course_id', $currentCourseId) // 単一IDで絞る
            ->latest()
            ->paginate(5);


        /*
        |--------------------------------------------------------------------------
        | その他表示用データ
        |--------------------------------------------------------------------------
        */
        $divisions = $user->division;
        $themes = Theme::where('is_show', 1)->get();

        /*
        |--------------------------------------------------------------------------
        | テーマ・フォントサイズをセッション保存
        |--------------------------------------------------------------------------
        */
        session([
            'settings' => [
                'theme_id' => $user_details?->theme_id ?? 1,
                'fontsize' => $user_details?->fontsize ?? 1,
            ]
        ]);

        return view('user.mypage.mypage', compact(
            'user',
            'user_details',
            'courses',
            'pending_diaries',
            'submitted_reports',
            'scheduledAnnouncements',
            'divisions',
            'themes'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | 未提出日報取得（講座注入型）
    |--------------------------------------------------------------------------
    */
    private function getPendingDiariesByCourses($user, $courses)
    {
        $pending = [];

        foreach ($courses as $course) {
            if (!$course->start_date || !$course->end_date) {
                continue;
            }

            $start = Carbon::parse($course->start_date);
            $end   = Carbon::parse($course->end_date);

            $period = new DatePeriod(
                $start,
                new DateInterval('P1D'),
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
                    $diary->url = route('user.reports_create', [
                        'course_id' => $course->id,
                        'date'      => $date->format('Y-m-d'),
                    ]);

                    $pending[] = $diary;
                }
            }
        }

        // 同一日付は1件にまとめる
        return collect($pending)
            ->unique('date')
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | フォントサイズ更新
    |--------------------------------------------------------------------------
    */
    public function updateFontsize(Request $request)
    {
        $request->validate([
            'fontsize' => 'required|integer|min:1|max:3',
        ]);

        $user = auth()->user();

        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            ['fontsize' => $request->fontsize]
        );

        return back()->with('success', '文字サイズを更新しました');
    }

    /*
    |--------------------------------------------------------------------------
    | テーマ更新
    |--------------------------------------------------------------------------
    */
    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme_id' => 'required|exists:themes,id',
        ]);

        $user = auth()->user();
        $details = $user->detail ?? $user->detail()->create([]);

        $details->theme_id = $request->theme_id;
        $details->save();

        return back()->with('success', 'テーマを変更しました。');
    }

    /*
    |--------------------------------------------------------------------------
    | テーマ・フォントサイズ一括更新
    |--------------------------------------------------------------------------
    */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'fontsize'    => 'nullable|integer|min:1|max:3',
            'theme_id'    => 'nullable|exists:themes,id',
            'avatar_type' => 'nullable|in:1,2,3', // ← 追加
        ]);

        $user = auth()->user();
        $details = $user->detail ?? $user->detail()->create([]);

        if ($request->filled('fontsize')) {
            $details->fontsize = $request->fontsize;
        }

        if ($request->filled('theme_id')) {
            $details->theme_id = $request->theme_id;
        }

        if ($request->filled('avatar_type')) {
            $details->avatar_type = $request->avatar_type; // ← 追加
        }

        $details->save();

        session([
            'settings' => [
                'theme_id' => $details->theme_id,
                'fontsize' => $details->fontsize,
            ]
        ]);

        return back()->with('success', '設定を更新しました。');
    }


    /*
    |--------------------------------------------------------------------------
    | アバター変更
    |--------------------------------------------------------------------------
    */
    public function updateAvatarType(Request $request)
    {
        $request->validate([
            'avatar_type' => 'required|in:1,2,3',
        ]);

        $user = auth()->user();

        $detail = $user->detail ?? $user->detail()->create([]);
        $detail->avatar_type = $request->avatar_type;
        $detail->save();

        return back()->with('success', 'アバター表示を変更しました');
    }

    /*
    |--------------------------------------------------------------------------
    | メモ保存
    |--------------------------------------------------------------------------
    */
    public function saveMemo(Request $request)
    {
        $user = auth()->user();
        $detail = $user->detail ?? $user->detail()->create([]);

        $detail->memo = $request->input('memo');
        $detail->save();

        return back()->with('success', 'メモを保存しました');
    }
}
