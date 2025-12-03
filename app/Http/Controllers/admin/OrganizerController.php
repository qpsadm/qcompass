<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organizer;

class OrganizerController extends Controller
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

    public function index(Request $request)
    {
        // 1ページあたり10件でページネーション
        $organizers = Organizer::orderBy('name', 'asc')->paginate(10);

        return view('admin.organizers.index', compact('organizers'));
    }

    public function create()
    {
        return view('admin.organizers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable',
        ]);
        Organizer::create($validated);
        return redirect()->route('admin.organizers.index')->with('success', 'Organizer作成完了');
    }

    public function show($id)
    {
        $Organizer = Organizer::findOrFail($id);
        return view('admin.organizers.show', compact('Organizer'));
    }

    public function edit($id)
    {
        $Organizer = Organizer::findOrFail($id);
        return view('admin.organizers.edit', compact('Organizer'));
    }

    public function update(Request $request, $id)
    {
        $Organizer = Organizer::findOrFail($id);
        $validated = $request->validate([
            'name' => 'nullable',
        ]);
        $Organizer->update($validated);
        return redirect()->route('admin.organizers.index')->with('success', 'Organizer更新完了');
    }

    public function destroy($id)
    {
        Organizer::findOrFail($id)->delete();
        return redirect()->route('admin.organizers.index')->with('success', 'Organizer削除完了');
    }
}
