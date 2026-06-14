<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportSubmitted;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 日報一覧（ログインユーザーのみ）
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(5);

        return view('user.mypage.reports_info', compact('reports'));
    }

    /*
    |--------------------------------------------------------------------------
    | 日報作成フォーム
    |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        $courseId = session('course_id');

        if (!$courseId) {
            return redirect()
                ->route('user.mypage')
                ->with('error', '講座が選択されていません。');
        }

        $course = Course::find($courseId);

        if (!$course) {
            abort(403, '無効な講座です');
        }

        // 日付は補助情報（URL から来てもOK）
        $date = $request->input('date');

        return view('user.mypage.reports_create', compact('course', 'date'));
    }

    /*
    |--------------------------------------------------------------------------
    | 確認画面
    |--------------------------------------------------------------------------
    */
    public function confirm(Request $request)
    {
        $inputs = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email',
            'date'          => 'required|date',
            'daily_report'  => 'required|string',
            'impression'    => 'required|string',
            'message'       => 'nullable|string',
        ]);

        $courseId = session('course_id');
        $course = $courseId
            ? Course::find($courseId)
            : null;

        return view('user.mypage.reports_confirm', compact(
            'inputs',
            'course'
        ));
    }



    /*
    |--------------------------------------------------------------------------
    | 日報保存
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $courseId = session('course_id');

        if (!$courseId) {
            abort(403, '講座が選択されていません');
        }

        $course = Course::findOrFail($courseId);

        $validated = $request->validate([
            'date'         => 'required|date',
            'daily_report' => 'required|string',
            'impression'   => 'required|string',
            'message'      => 'nullable|string',
            'email'        => 'required|email',
        ]);

        $report = Report::create([
            'user_id'           => Auth::id(),
            'course_id'         => $course->id, // ← session 由来
            'date'              => $validated['date'],
            'title'             => $course->course_name . ' -  就職支援訓練日報 ',
            'content'           => $validated['daily_report'],
            'impression'        => $validated['impression'],
            'notice'            => $validated['message'] ?? null,
            'created_user_name' => Auth::user()->name ?? 'system',
            'updated_user_name' => Auth::user()->name ?? 'system',
        ]);

        // 必要ならここで session 破棄も可
        // session()->forget('course_id');

        // 1. To（送信先）の配列を作成
        $recipients = [
            Auth::user()->email, // 提出者本人
        ];

        // .env から講師のアドレス（MAIL_SEND_ADDRESS）を取得して追加
        // $teacherEmail = config('mail.send_address');
        // if ($teacherEmail) {
        //     $recipients[] = $teacherEmail;
        // }

        // courses から講師のアドレスを取得して追加
        $teacherEmail = $course->mail_address;
        if ($teacherEmail) {
            $recipients[] = $teacherEmail;
        }

        // 2. メール送信処理（CCの判定付き）
        $mail = Mail::to($recipients);

        // courses にCCアドレスが設定されていればCCに追加
        $ccEmail = $course->cc_address;
        if (!empty($ccEmail)) {
            $mail->cc($ccEmail);
        }

        // queue から send に変更して同期送信（前回の対策）
        $mail->send(new ReportSubmitted($report));

        return redirect()
            ->route('user.reports.complete')
            ->with('success', '日報を送信しました');
    }

    /*
    |--------------------------------------------------------------------------
    | 完了画面
    |--------------------------------------------------------------------------
    */
    public function complete()
    {
        return view('user.mypage.reports_complete');
    }

    /*
    |--------------------------------------------------------------------------
    | 個別日報詳細
    |--------------------------------------------------------------------------
    */
    public function show(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, '権限がありません');
        }

        $course = $report->course;

        return view('user.mypage.reports_info', compact('report', 'course'));
    }

    /*
    |--------------------------------------------------------------------------
    | 削除
    |--------------------------------------------------------------------------
    */
    public function destroy(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, '権限がありません');
        }

        $report->delete();

        return redirect()
            ->route('user.reports_info')
            ->with('success', '日報を削除しました');
    }
}
