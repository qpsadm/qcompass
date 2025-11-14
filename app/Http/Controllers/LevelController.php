<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;

class LevelController extends Controller
{
    public function index()
    {
        $Level = Level::all();
        return view('Level.index', compact('Level'));
    }

    public function create()
    {
        return view('Level.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable',
            'name' => 'nullable',
        ]);
        Level::create($validated);
        return redirect()->route('Level.index')->with('success', 'Level作成完了');
    }

    public function show($id)
    {
        $Level = Level::findOrFail($id);
        return view('Level.show', compact('Level'));
    }

    public function edit($id)
    {
        $Level = Level::findOrFail($id);
        return view('Level.edit', compact('Level'));
    }

    public function update(Request $request, $id)
    {
        $Level = Level::findOrFail($id);
        $validated = $request->validate([
            'code' => 'nullable',
            'name' => 'nullable',
        ]);
        $Level->update($validated);
        return redirect()->route('Level.index')->with('success', 'Level更新完了');
    }

    public function destroy($id)
    {
        Level::findOrFail($id)->delete();
        return redirect()->route('Level.index')->with('success', 'Level削除完了');
    }
}