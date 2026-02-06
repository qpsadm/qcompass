<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AchievementsRelease;
use App\Models\User;
use App\Models\Achievement;

class AchievementsReleaseController extends Controller
{
    /**
     * 実績解除一覧
     */
    public function index(Request $request)
    {
        $query = AchievementsRelease::with(['user', 'achievement', 'user.courses']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('achievement', function ($q3) use ($search) {
                        $q3->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user.courses', function ($q4) use ($search) {
                        $q4->where('course_name', 'like', "%{$search}%");
                    });
            });
        }

        $achievements_release = $query->get();

        return view('admin.achievements_release.index', compact('achievements_release'));
    }


    /**
     * 作成フォーム
     */
    public function create()
    {
        $users = User::all();
        $achievements = Achievement::all();
        return view('admin.achievements_release.create', compact('users', 'achievements'));
    }

    /**
     * 新規作成保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'achievement_master_id' => 'required|exists:achievements,id',
            'unlocked_at' => 'required|date',
            'condition_met' => 'nullable|string',
        ]);

        AchievementsRelease::create($validated);

        return redirect()->route('admin.achievements_release.index')
            ->with('success', '実績解除を作成しました');
    }

    /**
     * 詳細表示
     */
    public function show($id)
    {
        $AchievementsRelease = AchievementsRelease::with(['user', 'achievement'])->findOrFail($id);
        return view('admin.achievements_release.show', compact('AchievementsRelease'));
    }

    /**
     * 編集フォーム
     */
    public function edit($id)
    {
        $AchievementsRelease = AchievementsRelease::findOrFail($id);
        $users = User::all();
        $achievements = Achievement::all();
        return view('admin.achievements_release.edit', compact('AchievementsRelease', 'users', 'achievements'));
    }

    /**
     * 更新
     */
    public function update(Request $request, $id)
    {
        $AchievementsRelease = AchievementsRelease::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'achievement_master_id' => 'required|exists:achievements,id',
            'unlocked_at' => 'required|date',
            'condition_met' => 'nullable|string',
        ]);

        $AchievementsRelease->update($validated);

        return redirect()->route('admin.achievements_release.index')
            ->with('success', '実績解除を更新しました');
    }

    /**
     * 削除
     */
    public function destroy($id)
    {
        AchievementsRelease::findOrFail($id)->delete();

        return redirect()->route('admin.achievements_release.index')
            ->with('success', '実績解除を削除しました');
    }
}
