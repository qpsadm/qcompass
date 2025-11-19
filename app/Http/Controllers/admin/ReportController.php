<?php

namespace App\Http\Controllers\Admin; // ここ重要！

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user', 'course'])->latest()->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    public function create()
    {
        return view('admin.reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Report::create(array_merge($request->all(), [
            'user_id' => Auth::id(),
            'created_user_id' => Auth::id(),
        ]));

        return redirect()->route('admin.reports.index')->with('success', '日報を登録しました。');
    }

    public function edit(Report $report)
    {
        return view('admin.reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $report->update(array_merge($request->all(), [
            'updated_user_id' => Auth::id(),
        ]));

        return redirect()->route('admin.reports.index')->with('success', '日報を更新しました。');
    }

    public function destroy(Report $report)
    {
        $report->update(['deleted_user_id' => Auth::id()]);
        $report->delete();
        return redirect()->route('admin.reports.index')->with('success', '日報を削除しました。');
    }
}
