<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // ログインユーザーの報告だけを取得
        $reports = Report::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get();

        return view('user.mypage.reports_info', compact('reports'));
    }
    /**
     * 日報作成フォーム
     */
    public function create()
    {
        return view('user.mypage.reports_create');
    }

    /**
     * 日報保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|integer',
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'impression' => 'nullable|string',
            'notice' => 'nullable|string',
        ]);

        Report::create([
            'user_id' => auth()->id(),
            'course_id' => $request->course_id,
            'date' => $request->date,
            'title' => $request->title,
            'content' => $request->content,
            'impression' => $request->impression,
            'notice' => $request->notice,
            'created_user_name' => auth()->user()->name,
            'updated_user_name' => auth()->user()->name,
        ]);

        return redirect()->route('user.mypage.reports_info')->with('success', '日報を作成しました');
    }
}