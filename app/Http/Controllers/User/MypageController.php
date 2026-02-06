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
use App\Models\Report;

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
        | 各種スケジュール（type_id = 6）
        |--------------------------------------------------------------------------
        */
        $currentCourseId = session('course_id'); // 現在ログイン中の講座ID

        $scheduledAnnouncements = Announcement::where('type_id', 6)
            ->where('is_show', 1)
            ->where('course_id', $currentCourseId) // 単一IDで絞る
            ->orderBy('updated_at', 'desc')
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
        $pending = collect();

        foreach ($courses as $course) {
            if (!$course->start_date || !$course->end_date) {
                continue;
            }

            $start = Carbon::parse($course->start_date);
            $end   = Carbon::parse($course->end_date);

            // ① 提出済み日付を一気に取得（★重要）
            $submittedDates = $user->reports()
                ->where('course_id', $course->id)
                ->pluck('date')
                ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
                ->toArray();

            // ② 全期間を回す（DBアクセスなし）
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $dateStr = $date->format('Y-m-d');

                if (!in_array($dateStr, $submittedDates, true)) {
                    $pending->push((object)[
                        'date'        => $dateStr,
                        'course_id'   => $course->id,
                        'course_name' => $course->course_name,
                        'url'         => route('user.reports_create', [
                            'course_id' => $course->id,
                            'date'      => $dateStr,
                        ]),
                    ]);
                }
            }
        }

        return $pending
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
            'avatar_type' => 'nullable|in:1,2,3,4,5,6,99',
            'avatar_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();
        $details = $user->detail ?? $user->detail()->create([]);

        /* -------------------------
     | フォントサイズ
     |------------------------- */
        if ($request->filled('fontsize')) {
            $details->fontsize = $request->fontsize;
        }

        /* -------------------------
     | テーマ
     |------------------------- */
        if ($request->filled('theme_id')) {
            $details->theme_id = $request->theme_id;
        }

        /* -------------------------
     | アバター処理
     |------------------------- */
        if ($request->filled('avatar_type')) {

            // ★ カスタム画像（99）
            if ((int)$request->avatar_type === 99 && $request->hasFile('avatar_file')) {

                // 既存カスタム画像削除
                if ($details->user_avatar_path) {
                    Storage::disk('public')->delete($details->user_avatar_path);
                }

                $filename = 'avatar_' . $user->id . '_' . Str::uuid() . '.' .
                    $request->file('avatar_file')->getClientOriginalExtension();

                $path = $request->file('avatar_file')
                    ->storeAs('avatars', $filename, 'public');

                $details->avatar_type = 99;
                $details->user_avatar_path = $path;
            } else {
                // ★ 既存アバター（1〜6）
                $details->avatar_type = $request->avatar_type;
                $details->user_avatar_path = null;
            }
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
            'avatar_type' => 'required|in:1,2,3,4,5,6,99',
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
