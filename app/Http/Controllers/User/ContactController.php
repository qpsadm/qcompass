<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportSubmitted;

class ContactController extends Controller
{
    // 日報作成フォーム
    public function create(Request $request)
    {
        return view('user.contact.contact_create');
    }

    // 日報保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'date'         => 'required|date',
            'daily_report' => 'required|string',
            'impression'   => 'required|string',
            'message'      => 'nullable|string',
        ]);

        $report = Report::create([
            'user_id'            => Auth::id(),
            'course_id'          => $validated['course_id'],      // hidden input
            'date'               => $validated['date'],           // フォーム入力を優先
            'title'              => '問い合わせ内容',
            'content'            => $validated['daily_contact'],
            'impression'         => $validated['impression'],
            'notice'             => $validated['message'] ?? null,
            'created_user_name'  => Auth::user()->name ?? 'system',
            'updated_user_name'  => Auth::user()->name ?? 'system',
        ]);

        // メール送信（任意）
        $recipients = [Auth::user()->email, 'weishangli878@gmail.com'];
        foreach ($recipients as $email) {
            Mail::to($email)->send(new ReportSubmitted($report));
        }

        return redirect()->route('user.reports_complete')
            ->with('success', '日報を送信しました');
    }

    //問い合わせ確認フォーム
    public function confirm(Request $request)
    {
        // 入力データを取得
        $inputs = $request->all();
        return view('user.contact.contact_confirm', compact('inputs'));
    }

    //問い合わせ完了フォーム
    public function complete()
    {
        return view('user.contact.contact_complete');
    }
}