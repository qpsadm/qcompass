<?php

// app/Http/Controllers/Admin/ReportController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportSubmitted;
use App\Models\Course;

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
            // $allowed = ['reports', 'course_teacher', 'questions', 'agenda'];
            $allowed = ['questions', 'agenda'];
            $path = request()->path();
            foreach ($allowed as $a) {
                if (str_contains($path, $a)) {
                    return; // OK
                }
            }
            abort(403, 'アクセス権限がありません。');
        }
    }

    // 一覧
    public function index(Request $request)
    {
        // $query = Report::query();

        /*
    |--------------------------------------------------------------------------
    | 検索
    |--------------------------------------------------------------------------
    */
        $courseId   = $request->input('course_id');   // 講座IDフィルタ
        $search     = $request->input('search');

        // 並び替えパラメータ
        $sort = $request->get('sort', 'course_id');          // デフォルト No.
        $direction = $request->get('direction', 'desc'); // asc / desc

        // ソート可能カラム（安全対策）
        $allowedSorts = ['id', 'course_id', 'user_id', 'is_show', 'updated_at'];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        $reports = Report::query()
            ->with(['user', 'course']);

        // ユーザーネーム、日報タイトル
        if ($search) {
            $reports->where(function ($q) use ($search) {
                // ユーザ名
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%");
                })
                    // // コース名
                    // ->orWhereHas('course', function ($cq) use ($search) {
                    //     $cq->where('course_name', 'like', "%{$search}%");
                    // })

                    // 日報タイトル
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // 🎓 講座絞り込み
        if ($courseId) {
            $reports->whereHas('course', function ($q) use ($courseId) {
                $q->where('courses.id', $courseId);
            });
        }

        /*
    |--------------------------------------------------------------------------
    | 日付範囲検索（未使用）
    |--------------------------------------------------------------------------
    */
        if ($from = $request->input('from_date')) {
            $reports->whereDate('date', '>=', $from);
        }

        if ($to = $request->input('to_date')) {
            $reports->whereDate('date', '<=', $to);
        }

        /*
    |--------------------------------------------------------------------------
    | ソート処理
    |--------------------------------------------------------------------------
    */

        // 許可するソートカラム
        $sortable = [
            'date',
            'created_at',
            'user_id',
            'course_id',
            'title',
        ];

        if (!in_array($sort, $sortable)) {
            $sort = 'date';
        }

        /*
    |--------------------------------------------------------------------------
    | データ取得
    |--------------------------------------------------------------------------
    */
        $reports = $reports
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->onEachSide(1)         //左にあるページネーションのボタン数を減らす
            ->withQueryString();

        // プルダウン用講座一覧
        $courses = Course::where('is_show', 1)
            ->orderBy('id', 'desc')->get();


        return view(
            'admin.reports.index',
            compact(
                'courses',
                'reports',
                'sort',
                'direction'
            )
        );
    }


    // 作成フォーム
    public function create()
    {
        $courseId = session('course_id');
        $courses = $courseId
            ? \App\Models\Course::where('id', $courseId)->get()
            : collect();

        return view('admin.reports.create', compact('courses'));
    }


    // 保存＋メール送信
    public function store(Request $request)
    {
        $courseId = session('course_id');

        if (!$courseId) {
            abort(403, '講座が選択されていません');
        }

        $validated = $request->validate([
            'date'       => 'required|date',
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'impression' => 'required|string',
            'notice'     => 'nullable|string',
        ]);

        // DB保存
        $report = Report::create(array_merge($validated, [
            'course_id' => $courseId,
            'user_id'   => Auth::id(),
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