<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;

class LevelController extends Controller
{
    /**
     * 一覧（並び替え対応）
     */
    public function index(Request $request)
    {
        // 並び替えパラメータ
        $sort = $request->get('sort', 'id');          // デフォルト No.
        $direction = $request->get('direction', 'asc'); // asc / desc

        // ソート可能カラム（安全対策）
        $allowedSorts = ['id', 'code', 'name', 'is_show', 'updated_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        // 一覧取得
        $levels = Level::orderBy($sort, $direction)
            ->paginate(10)
            ->appends($request->query()); // ページ遷移時に保持

        return view(
            'admin.levels.index',
            compact(
                'levels',
                'sort',
                'direction'
            )
        );
    }

    /**
     * 新規作成画面
     */
    public function create()
    {
        return view('admin.levels.create');
    }

    /**
     * 保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:10|unique:levels,code',
            'name' => 'nullable|string|max:255',
            'is_show' => 'required|boolean',
        ]);

        Level::create($validated);

        return redirect()
            ->route('admin.levels.index')
            ->with('success', 'Level作成完了');
    }

    /**
     * 詳細（未使用なら消してOK）
     */
    public function show($id)
    {
        $Level = Level::findOrFail($id);
        return view('admin.levels.show', compact('Level'));
    }

    /**
     * 編集画面
     */
    public function edit($id)
    {
        $Level = Level::findOrFail($id);
        return view('admin.levels.edit', compact('Level'));
    }

    /**
     * 更新
     */
    public function update(Request $request, $id)
    {
        $Level = Level::findOrFail($id);

        $validated = $request->validate([
            'code' => 'nullable|string|max:10|unique:levels,code,' . $Level->id,
            'name' => 'nullable|string|max:255',
            'is_show' => 'required|boolean',
        ]);

        $Level->update($validated);

        return redirect()
            ->route('admin.levels.index')
            ->with('success', 'Level更新完了');
    }

    /**
     * 削除（編集画面からのみ想定）
     */
    public function destroy($id)
    {
        Level::findOrFail($id)->delete();

        return redirect()
            ->route('admin.levels.index')
            ->with('success', 'Level削除完了');
    }
}
