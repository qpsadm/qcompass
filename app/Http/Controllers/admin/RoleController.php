<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        // 並び替えパラメータ
        $sort = $request->get('sort', 'id');          // デフォルト
        $direction = $request->get('direction', 'asc'); // asc / desc

        // ソート可能カラム（安全対策）
        $allowedSorts = ['id', 'role_name', 'updated_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        // 1ページあたり10件でページネーション
        $roles = Role::orderBy($sort, $direction)
            ->paginate(10)
            ->onEachSide(1);         //左にあるページネーションのボタン数を減らす

        return view(
            'admin.roles.index',
            compact('roles', 'sort', 'direction')
        );
    }
    public function create()
    {
        $roles = Role::all();
        return view('admin.roles.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id'   => 'required|integer|min:1|max:9|unique:roles,role_id',
            'role_name' => 'required|string|max:50',
        ]);

        // 自動的に created_at / updated_at が入ります（timestamps）
        \App\Models\Role::create($validated);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', '権限を作成しました。');
    }

    public function show($id)
    {
        $Role = Role::findOrFail($id);
        return view('admin.roles.show', compact('Role'));
    }

    // 編集画面表示
    public function edit($id)
    {
        $Role = Role::findOrFail($id);
        $roles = Role::all(); // 他の role_id の確認用
        return view('admin.roles.edit', compact('Role', 'roles'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'role_id'   => 'required|integer|min:0|max:9|unique:roles,role_id,' . $id,
            'role_name' => 'required|string|max:50',
        ]);

        $role = Role::findOrFail($id);
        $role->update($validated);

        return redirect()->route('admin.roles.index')->with('success', '更新完了');
    }


    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role削除完了');
    }
}
