<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learning;
use App\Models\Tag;

class LearningController extends Controller
{
    /**
     * 一覧表示（管理者用）
     */
    public function index()
    {
        // Learningモデルとその関連タグ情報を一緒に取得
        $learnings = Learning::with('tag')->get();
        return view('learning.index', compact('learnings'));
    }

    /**
     * 作成フォーム
     */
    public function create()
    {
        // タグ情報を取得
        $tags = Tag::all();  // タグのリストを取得
        return view('learning.create', compact('tags'));
    }

    /**
     * 新規作成処理
     */
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'type' => 'required|in:book,site,video,article',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'level' => 'nullable|integer|min:1|max:5',
            'is_show' => 'nullable|boolean',
            'tag_id' => 'nullable|exists:tags,id', // タグIDのバリデーション
        ]);

        // 公開状態の処理
        $validated['is_show'] = $request->boolean('is_show');


        // タグIDの設定（タグが選択されていない場合は null）
        $validated['tag_id'] = $validated['tag_id'] ?? null;

        // Learningデータの保存
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
        $tags = Tag::all();  // タグ情報を取得
        return view('learning.edit', compact('learning', 'tags'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, $id)
    {
        $learning = Learning::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'type' => 'required|in:book,site,video,article',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'level' => 'nullable|integer|min:1|max:5',
            'is_show' => 'nullable|boolean',
            'tag_id' => 'nullable|exists:tags,id', // タグIDのバリデーション
        ]);

        // 公開状態の処理
        $validated['is_show'] = $request->boolean('is_show');


        // タグIDの設定（タグが選択されていない場合は null）
        $validated['tag_id'] = $validated['tag_id'] ?? null;

        // 更新処理
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
