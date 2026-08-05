<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    private function checkCrudPermission()
    {
        $roleId = auth()->user()->role_id;

        // role 4: 閲覧のみ
        if ($roleId == 4) {
            $editableRoutes = ['create', 'store', 'edit', 'update', 'destroy'];
            foreach ($editableRoutes as $route) {
                if (\Route::currentRouteAction() && str_contains(\Route::currentRouteAction(), $route)) {
                    abort(403, 'アクセス権限がありません。');
                }
            }
        }

        // role 5: 制限付き
        if ($roleId == 5) {
            $allowed = ['questions', 'reports', 'course_teacher', 'agenda'];
            $path = request()->path();
            foreach ($allowed as $a) {
                if (str_contains($path, $a)) {
                    return;
                }
            }
            abort(403, 'アクセス権限がありません。');
        }
    }

    public function index(Request $request)
    {
        // 並び替え（Organizer と統一）
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        // ホワイトリスト（安全対策）
        $sortableColumns = ['id', 'code', 'name', 'updated_at'];
        if (!in_array($sort, $sortableColumns)) {
            $sort = 'id';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $tags = Tag::orderBy($sort, $direction)
            ->paginate(10)
            ->onEachSide(1);         //左にあるページネーションのボタン数を減らす

        return view('admin.tags.index', compact(
            'tags',
            'sort',
            'direction'
        ));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string',
            'name' => 'required|string',
            'is_show' => 'nullable|boolean',
        ]);

        // is_show のデフォルト
        $validated['is_show'] = $validated['is_show'] ?? 0;

        // ⭐ code が空なら name を入れる
        if (empty($validated['code'])) {
            $validated['code'] = $validated['name'];
        }

        Tag::create($validated);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag作成完了');
    }


    public function edit($id)
    {
        $Tag = Tag::findOrFail($id);
        return view('admin.tags.edit', compact('Tag'));
    }

    public function update(Request $request, $id)
    {
        $Tag = Tag::findOrFail($id);

        $validated = $request->validate([
            'code'    => 'nullable|string|max:50',
            'name'    => 'nullable|string|max:255',
            'is_show' => 'nullable|boolean',
        ]);

        $validated['is_show'] = $validated['is_show'] ?? 0;

        $Tag->update($validated);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag更新完了');
    }

    public function destroy($id)
    {
        Tag::findOrFail($id)->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag削除完了');
    }
}
