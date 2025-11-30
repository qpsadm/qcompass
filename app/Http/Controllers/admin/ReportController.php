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
    public function index(Request $request)
    {
        $query = \App\Models\Report::query();

        // ユーザー名・講座名・タイトル検索
        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('course', function ($q) use ($search) {
                $q->where('course_name', 'like', "%{$search}%");
            })->orWhere('title', 'like', "%{$search}%");
        }

        // 日付範囲検索
        if ($from = $request->input('from_date')) {
            $query->where('date', '>=', $from);
        }
        if ($to = $request->input('to_date')) {
            $query->where('date', '<=', $to);
        }

        $reports = $query->with(['user', 'course'])
            ->orderBy('date', 'desc')
            ->paginate(5);

        return view('admin.reports.index', compact('reports'));
    }


    // 作成フォーム
    public function create()
    {
        $user = auth()->user();
        $courses = $user->courses()->get();

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
            'impression' => 'required|string',
            'notice'     => 'nullable|string',
        ]);

        // DB保存
        $report = Report::create(array_merge($validated, [
            'user_id'         => Auth::id(),
            'created_user_name' => auth()->user()->name ?? 'system',
            'updated_user_name' => auth()->user()->name ?? 'system',
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

    // POST送信を受ける
    public function previewBlade(Request $request)
    {
        // フォームから送られたデータを全部取得
        $reportData = $request->all();

        // 講座IDがあれば講座名を取得
        $course = null;
        if (!empty($reportData['course_id'])) {
            $course = \App\Models\Course::find($reportData['course_id']);
        }

        return view('admin.reports.preview', [
            'report' => $reportData,
            'course' => $course,
        ]);
    }

    public function show(Report $report)
    {
        // 講座情報を取得
        $course = $report->course;

        return view('admin.reports.show', compact('report', 'course'));
    }

    public function destroy(Report $report)
    {
        $report->delete(); // DBから削除
        return redirect()->route('admin.reports.index')
            ->with('success', '日報を削除しました。');
    }
}
