<?php

// app/Http/Controllers/Admin/ReportController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportSubmitted;

class ReportController extends Controller
{
    // 一覧
    public function index()
    {
        $reports = Report::with(['user', 'course'])->latest()->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    // 作成フォーム
    public function create()
    {
        $courses = \App\Models\Course::all(); // 講座一覧を取得
        return view('admin.reports.create', compact('courses'));
    }

    // 保存＋メール送信
    public function store(Request $request)
    {
        // ← ここにバリデーションを書く
        $validated = $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'date'       => 'required|date',
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'impression' => 'required|string',   // 必須にする
            'notice'     => 'nullable|string',
        ]);

        // DB保存
        $report = Report::create(array_merge($validated, [
            'user_id'         => Auth::id(),
            'created_user_id' => Auth::id(),
            'updated_user_id' => Auth::id(),
        ]));

        // 送信先（提出者＋上司）
        $recipients = [
            Auth::user()->email,
            'manager@example.com',
        ];

        foreach ($recipients as $email) {
            Mail::to($email)->queue(new ReportSubmitted($report)); // queueで非同期送信
        }

        return redirect()->route('admin.reports.index')->with('success', '日報を登録しました。通知メールを送信しました。');
    }

    public function previewBlade(Request $request)
    {
        // フォーム送信データで Report オブジェクトを作る（DBには保存しない）
        $report = new \App\Models\Report($request->all());

        // preview.blade.php に渡す
        return view('admin.reports.preview', compact('report'));
    }

    public function destroy(Report $report)
    {
        $report->delete(); // DBから削除
        return redirect()->route('admin.reports.index')
            ->with('success', '日報を削除しました。');
    }
}
