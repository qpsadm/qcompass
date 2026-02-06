<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Achievement;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::all();
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable',
            'description' => 'nullable',
            'condition_type' => 'nullable',
            'condition_value' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        Achievement::create($validated);
        return redirect()->route('admin.achievements.index')->with('success', 'Achievement作成完了');
    }

    public function show($id)
    {
        $Achievement = Achievement::findOrFail($id);
        return view('admin.achievements.show', compact('Achievement'));
    }

    public function edit($id)
    {
        $Achievement = Achievement::findOrFail($id);
        return view('admin.achievements.edit', compact('Achievement'));
    }

    public function update(Request $request, $id)
    {
        $Achievement = Achievement::findOrFail($id);
        $validated = $request->validate([
            'title' => 'nullable',
            'description' => 'nullable',
            'condition_type' => 'nullable',
            'condition_value' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $Achievement->update($validated);
        return redirect()->route('admin.achievements.index')->with('success', 'Achievement更新完了');
    }

    public function destroy($id)
    {
        Achievement::findOrFail($id)->delete();
        return redirect()->route('admin.achievements.index')->with('success', 'Achievement削除完了');
    }
}
