<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::all();
        return view('admin.levels.index', compact('levels'));
    }

    public function create()
    {
        return view('admin.levels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:10|unique:levels,code', // ←ユニーク制約追加
            'name' => 'nullable|string|max:255',
            'is_show' => 'required|boolean',
        ]);

        Level::create($validated);

        return redirect()->route('admin.levels.index')->with('success', 'Level作成完了');
    }

    public function show($id)
    {
        $Level = Level::findOrFail($id);
        return view('admin.levels.show', compact('Level'));
    }

    public function edit($id)
    {
        $Level = Level::findOrFail($id);
        return view('admin.levels.edit', compact('Level'));
    }

    public function update(Request $request, $id)
    {
        $Level = Level::findOrFail($id);

        $validated = $request->validate([
            'code' => 'nullable|string|max:10|unique:levels,code,' . $Level->id, // ←自分以外と重複しない
            'name' => 'nullable|string|max:255',
            'is_show' => 'required|boolean',
        ]);

        $Level->update($validated);

        return redirect()->route('admin.levels.index')->with('success', 'Level更新完了');
    }


    public function destroy($id)
    {
        Level::findOrFail($id)->delete();
        return redirect()->route('admin.levels.index')->with('success', 'Level削除完了');
    }
}
