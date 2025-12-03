<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseType;
use App\Models\Organizer;

class CourseTypeController extends Controller
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
        // 1ページあたり10件でページネーション
        $course_types = CourseType::with('organizer')->orderBy('name')->paginate(10);

        return view('admin.course_type.index', compact('course_types'));
    }
    public function create()
    {
        $organizers = Organizer::all();
        return view('admin.course_type.create', compact('organizers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable',
            'organizer_id' => 'required|exists:organizers,id',
            'is_show' => 'nullable|in:0,1',
        ]);

        $validated['is_show'] = (int) $request->input('is_show', 1);

        CourseType::create($validated);

        return redirect()->route('admin.course_type.index')->with('success', 'CourseType作成完了');
    }


    public function show($id)
    {
        $CourseType = CourseType::findOrFail($id);
        return view('admin.course_type.show', compact('CourseType'));
    }

    public function edit($id)
    {
        $CourseType = CourseType::findOrFail($id);
        $organizers = Organizer::all();
        return view('admin.course_type.edit', compact('CourseType', 'organizers'));
    }

    public function update(Request $request, $id)
    {
        $CourseType = CourseType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable',
            'is_show' => 'nullable|in:0,1',
        ]);

        $validated['is_show'] = $request->boolean('is_show');

        $CourseType->update($validated);

        return redirect()->route('admin.course_type.index')->with('success', 'CourseType更新完了');
    }



    public function destroy($id)
    {
        CourseType::findOrFail($id)->delete();
        return redirect()->route('admin.course_type.index')->with('success', 'CourseType削除完了');
    }
}
