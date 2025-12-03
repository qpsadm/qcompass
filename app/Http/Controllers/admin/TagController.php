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

        // role 1～3: 管理画面不可は middleware で弾かれる想定

        // role 4: 閲覧のみ
        if ($roleId == 4) {
            $editableRoutes = ['create', 'store', 'edit', 'update', 'destroy'];
            foreach ($editableRoutes as $route) {
                if (\Route::currentRouteAction() && str_contains(\Route::currentRouteAction(), $route)) {
                    abort(403, 'アクセス権限がありません。');
                }
            }
        }

        // role 5: 制限付き編集可
        if ($roleId == 5) {
            $allowed = ['questions', 'reports', 'course_teacher', 'agenda'];
            $path = request()->path();
            foreach ($allowed as $a) {
                if (str_contains($path, $a)) {
                    return; // OK
                }
            }
            abort(403, 'アクセス権限がありません。');
        }

        // role 6: 一部制限あり（必要ならここで制御）

        // role 7,8: フル CRUD → ここでは特にチェック不要
    }

    public function index()
    {
        $tags = Tag::all();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable',
            'name' => 'nullable',
            'is_show' => 'nullable|boolean',

        ]);

        $validated['is_show'] = $validated['is_show'] ?? 0;


        Tag::create($validated);
        return redirect()->route('admin.tags.index')->with('success', 'Tag作成完了');
    }

    public function show($id)
    {
        $Tag = Tag::findOrFail($id);
        return view('admin.tags.show', compact('Tag'));
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
            'code' => 'nullable',
            'name' => 'nullable',
            'is_show' => 'nullable|boolean',

        ]);

        $validated['is_show'] = $validated['is_show'] ?? 0;



        $Tag->update($validated);
        return redirect()->route('admin.tags.index')->with('success', 'Tag更新完了');
    }

    public function destroy($id)
    {
        Tag::findOrFail($id)->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag削除完了');
    }
}
