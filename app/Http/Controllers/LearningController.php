<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learning;

class LearningController extends Controller
{
    /**
     * 一覧表示（管理者用）
     */
    public function index()
    {
        $learnings = Learning::all();
        return view('learning.index', compact('learnings'));
    }

    /**
     * 作成フォーム
     */
    public function create()
    {
        return view('learning.create');
    }

    /**
     * 新規作成処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:book,site,video,article',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'level' => 'nullable|integer|min:1|max:5',
            'is_show' => 'nullable|boolean',
        ]);

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;


        Learning::create($validated);

        return redirect()->route('admin.learnings.index')->with('success', 'Learning作成完了');
    }

    /**
     * 詳細表示
     */
    public function show($id)
    {
        $learning = Learning::findOrFail($id);
        return view('learning.show', compact('learning'));
    }

    /**
     * 編集フォーム
     */
    public function edit($id)
    {
        $learning = Learning::findOrFail($id);
        return view('learning.edit', compact('learning'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, $id)
    {
        $learning = Learning::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:book,site,video,article',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'level' => 'nullable|integer|min:1|max:5',
            'is_show' => 'nullable|boolean',
        ]);


        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $learning->update($validated);

 
        return redirect()->route('admin.learnings.index')->with('success', 'Learning更新完了');
    }

    /**
     * 削除処理
     */
    public function destroy($id)
    {
        Learning::findOrFail($id)->delete();
        return redirect()->route('admin.learnings.index')->with('success', 'Learning削除完了');
    }
}
