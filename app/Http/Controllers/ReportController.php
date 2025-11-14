<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable',
            'course_id' => 'nullable',
            'date' => 'nullable',
            'title' => 'nullable',
            'content' => 'nullable',
            'impression' => 'nullable',
            'notice' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        Report::create($validated);
        return redirect()->route('reports.index')->with('success', 'Report作成完了');
    }

    public function show($id)
    {
        $Report = Report::findOrFail($id);
        return view('reports.show', compact('Report'));
    }

    public function edit($id)
    {
        $Report = Report::findOrFail($id);
        return view('reports.edit', compact('Report'));
    }

    public function update(Request $request, $id)
    {
        $Report = Report::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'nullable',
            'course_id' => 'nullable',
            'date' => 'nullable',
            'title' => 'nullable',
            'content' => 'nullable',
            'impression' => 'nullable',
            'notice' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        $Report->update($validated);
        return redirect()->route('reports.index')->with('success', 'Report更新完了');
    }

    public function destroy($id)
    {
        Report::findOrFail($id)->delete();
        return redirect()->route('reports.index')->with('success', 'Report削除完了');
    }
}