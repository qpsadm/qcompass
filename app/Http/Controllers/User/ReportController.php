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
        $user = auth()->user();
        $course = $user->myCourses()->first(); // 講座は1件固定

        // URL パラメータから日付取得
        $date = $request->query('date', now()->format('Y-m-d'));
        return view('user.mypage.reports_create', compact('course', 'date'));
    }

    // 日報保存&送信処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'date'         => 'required|date',
            'daily_report' => 'required|string',
            'impression'   => 'required|string',
            'message'      => 'nullable|string',
            'email'      => 'required|email',
        ]);

        $course_id = $validated['course_id'];
        $course = Course::find($course_id);

        $report = Report::create([
            'user_id'            => Auth::id(),
            'course_id'          => $validated['course_id'],      // hidden input
            'date'               => $validated['date'],           // フォーム入力を優先
            'title'              => '【日報】 - ' .
                $course->course_name,
            'content'            => $validated['daily_report'] . $course->mail_address . $course->cc_address,
            'impression'         => $validated['impression'],
            'notice'             => $validated['message'] ?? null,
            'created_user_name'  => Auth::user()->name ?? 'system',
            'updated_user_name'  => Auth::user()->name ?? 'system',
        ]);

        // $report->load('user'); // ★ replyTo のために必須

        // メール送信（任意）
        // $recipients = [Auth::user()->email, 'weishangli878@gmail.com'];
        // foreach ($recipients as $email) {
        //     Mail::to($email)->send(new ReportSubmitted($report));
        // }

        // 日報送信処理　 start

        // 送信宛先
        $send_address = $course->mail_address;

        // CC
        $cc_adress = $course->cc_address;

        // 入力から学生のメールアドレスを取得
        $studentEmail = $request->email;

        $addresses = [$send_address, $cc_adress, $studentEmail];

        // Mail::to($companyEmail)
        //     ->cc($studentEmail)
        //     ->queue(new ReportSubmitted($report));

        foreach ($addresses as $address) {
            try {
                Mail::to($address)->send(new ReportSubmitted($report));
            } catch (\Exception $e) {
                // ログに残したり通知したり
                Log::error("送信失敗: {$address} " . $e->getMessage());
            }
        }

        // Mail::to($send_address)
        //     ->cc($cc_list)
        //     ->send(new ReportSubmitted($report));

        // 日報送信処理　 end

        return redirect()->route('user.reports_complete')
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

    // public function confirm()
    // {
    //     return view('user.mypage.reports_confirm');
    // }

    // public function confirm(Request $request)
    // {
    //     // 入力データを取得
    //     $inputs = $request->all();

    //     return view('user.mypage.reports_confirm', compact('inputs'));
    // }

    public function confirm(Request $request)
    {
        $inputs = $request->all();

        // ユーザーが所属する講座を取得
        $user = Auth::user();
        $courses = $user->courses()->get();

        return view('user.mypage.reports_confirm', compact('inputs', 'courses'));
    }

    public function complete()
    {
        return view('user.mypage.reports_complete');
    }
}
