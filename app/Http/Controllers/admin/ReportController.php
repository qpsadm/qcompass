<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportSubmitted;

class ReportController extends Controller
{

    private function checkCrudPermission()
    {
        $roleId = auth()->user()->role_id;

        // role 1,2,3: 管理画面不可は middleware で弾かれる想定

        // role 4: 閲覧のみ
        if ($roleId == 4) {
            $editableRoutes = ['create', 'store', 'edit', 'update', 'destroy'];
            foreach ($editableRoutes as $route) {
                if (\Route::currentRouteAction() && str_contains(\Route::currentRouteAction(), $route)) {
                    abort(403, 'アクセス権限がありません。');
                }
            }
        }

        // role 5: 制限付き編集可
        if ($roleId == 5) {
            $allowed = ['reports', 'course_teacher', 'questions', 'agenda'];
            $path = request()->path();
            foreach ($allowed as $a) {
                if (str_contains($path, $a)) {
                    return; // OK
                }
            }
            abort(403, 'アクセス権限がありません。');
        }
    } // ← 閉じ波括弧を追加

    // 一覧
    public function index(Request $request)
    {
        $query = Report::query();

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
            ->paginate(20);

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
        $validated = $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'date'       => 'required|date',
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'impression' => 'required|string',
            'notice'     => 'nullable|string',
        ]);

        $report = Report::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'created_user_name' => auth()->user()->name ?? 'system',
            'updated_user_name' => auth()->user()->name ?? 'system',
        ]));

        $recipients = [
            Auth::user()->email,
            'manager@example.com',
        ];

        foreach ($recipients as $email) {
            Mail::to($email)->queue(new ReportSubmitted($report));
        }

        return redirect()->route('admin.reports.index')
            ->with('success', '日報を登録しました。通知メールを送信しました。');
    }

    // プレビュー
    public function previewBlade(Request $request)
    {
        $reportData = $request->all();
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
        $course = $report->course;
        return view('admin.reports.show', compact('report', 'course'));
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('admin.reports.index')
            ->with('success', '日報を削除しました。');
    }
}
