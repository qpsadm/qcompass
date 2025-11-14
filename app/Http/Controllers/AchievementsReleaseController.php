<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AchievementsRelease;

class AchievementsReleaseController extends Controller
{
    public function index()
    {
        $achievements_release = AchievementsRelease::all();
        return view('achievements_release.index', compact('achievements_release'));
    }

    public function create()
    {
        return view('achievements_release.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable',
            'achievement_master_id' => 'nullable',
            'unlocked_at' => 'nullable',
            'condition_met' => 'nullable',
        ]);
        AchievementsRelease::create($validated);
        return redirect()->route('achievements_release.index')->with('success', 'AchievementsRelease作成完了');
    }

    public function show($id)
    {
        $AchievementsRelease = AchievementsRelease::findOrFail($id);
        return view('achievements_release.show', compact('AchievementsRelease'));
    }

    public function edit($id)
    {
        $AchievementsRelease = AchievementsRelease::findOrFail($id);
        return view('achievements_release.edit', compact('AchievementsRelease'));
    }

    public function update(Request $request, $id)
    {
        $AchievementsRelease = AchievementsRelease::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'nullable',
            'achievement_master_id' => 'nullable',
            'unlocked_at' => 'nullable',
            'condition_met' => 'nullable',
        ]);
        $AchievementsRelease->update($validated);
        return redirect()->route('achievements_release.index')->with('success', 'AchievementsRelease更新完了');
    }

    public function destroy($id)
    {
        AchievementsRelease::findOrFail($id)->delete();
        return redirect()->route('achievements_release.index')->with('success', 'AchievementsRelease削除完了');
    }
}