<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;

class LevelController extends Controller
{
    // 一覧表示
    public function index()
    {
        $levels = Level::all();
        return view('level.index', compact('levels'));
    }

    // 作成フォーム
    public function create()
    {
        return view('level.create');
    }

    // 新規作成
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'is_show' => 'required|in:0,1',
        ]);

        $validated['is_show'] = (bool) $validated['is_show'];

        Level::create($validated);

        return redirect()->route('level.index')->with('success', 'Level作成完了');
    }

    // 詳細表示
    public function show($id)
    {
        $level = Level::findOrFail($id);
        return view('level.show', compact('level'));
    }

    // 編集フォーム
    public function edit($id)
    {
        $level = Level::findOrFail($id);
        return view('level.edit', compact('level'));
    }

    // 更新
    public function update(Request $request, $id)
    {
        $level = Level::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'is_show' => 'required|in:0,1',
        ]);


        $validated['is_show'] = (bool) $validated['is_show'];

        $level->update($validated);

        return redirect()->route('level.index')->with('success', 'Level更新完了');
    }

    // 削除
    public function destroy($id)
    {
        Level::findOrFail($id)->delete();
        return redirect()->route('level.index')->with('success', 'Level削除完了');
    }
}
