<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ReportSubmitted;
use App\Models\Course;

class ReportController extends Controller
{
    // 日報一覧（ログインユーザーのみ）
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(5);

        return view('user.mypage.reports_info', compact('reports'));
    }

    // 日報作成フォーム
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

        // 日付は URL から来ても OK（補助情報なので）
        $date = $request->input('date');

        return view('user.mypage.reports_create', compact('course', 'date'));
    }


    // 日報保存&送信処理
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
            'course_id'         => $course->id,   // ← session 由来
            'date'              => $validated['date'],
            'title'             => '【日報】 - ' . $course->course_name,
            'content'           => $validated['daily_report'],
            'impression'        => $validated['impression'],
            'notice'            => $validated['message'] ?? null,
            'created_user_name' => Auth::user()->name ?? 'system',
            'updated_user_name' => Auth::user()->name ?? 'system',
        ]);

        // メール送信（省略）

        return redirect()
            ->route('user.reports.complete')
            ->with('success', '日報を送信しました');
    }



    // 日報プレビュー（任意）
    public function preview(Request $request)
    {
        $reportData = $request->all();
        $course = null;
        if (!empty($reportData['course_id'])) {
            $course = \App\Models\Course::find($reportData['course_id']);
        }
        return view('user.mypage.reports_preview', [
            'report' => $reportData,
            'course' => $course,
        ]);
    }

    // 個別日報詳細
    public function show(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, '権限がありません');
        }

        $course = $report->course;

        return view('user.mypage.reports_info', compact('report', 'course'));
    }

    // 削除（必要なら）
    public function destroy(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, '権限がありません');
        }

        $report->delete();

        return redirect()->route('user.reports_info')
            ->with('success', '日報を削除しました');
    }

    public function confirm(Request $request)
    {
        $courseId = session('course_id');

        if (!$courseId) {
            return redirect()
                ->route('user.reports_create')
                ->with('error', '講座が選択されていません。');
        }

        $course = \App\Models\Course::find($courseId);

        if (!$course) {
            abort(403, '無効な講座です');
        }

        // フォーム入力だけ取得（course_id は含めない）
        $inputs = $request->validate([
            'date'         => 'required|date',
            'daily_report' => 'required|string',
            'impression'   => 'required|string',
            'message'      => 'nullable|string',
            'email'        => 'required|email',
        ]);

        return view('user.mypage.reports_confirm', compact('inputs', 'course'));
    }




    public function complete()
    {
        return view('user.mypage.reports_complete');
    }
}
