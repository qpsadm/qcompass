<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseTeacher;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseTeacherController extends Controller
{
    public function __construct()
    {
        // 全 CRUD メソッドで権限チェック
        $this->middleware(function ($request, $next) {
            $this->checkCrudPermission();
            return $next($request);
        });
    }

    public function index()
    {
        $course_teachers = CourseTeacher::all();

        return view('admin.course_teachers.index', compact('course_teachers'));
    }

    public function create()
    {
        // role_id 4以上のユーザーだけ取得
        $users = User::where('role_id', '>=', 4)->get();

        // 講座一覧を取得
        $courses = Course::all();

        return view('admin.course_teachers.create', compact('users', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'role_in_course' => 'required|integer',
        ]);

        // 作成者名を追加
        $validated['created_user_name'] = Auth::user()->name;

        CourseTeacher::create($validated);

        return redirect()->route('admin.course_teachers.index')->with('success', 'CourseTeacher作成完了');
    }

    public function show($id)
    {
        $CourseTeacher = CourseTeacher::findOrFail($id);
        return view('admin.course_teachers.show', compact('CourseTeacher'));
    }

    public function edit($id)
    {

        $CourseTeacher = CourseTeacher::findOrFail($id);
        $courses = Course::all();
        $users = User::all();
        return view('admin.course_teachers.edit', compact('CourseTeacher', 'courses', 'users'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role_id == 5) {
            abort(403, '権限がありません。');
        }

        $CourseTeacher = CourseTeacher::findOrFail($id);
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'role_in_course' => 'required|integer',
        ]);

        // 更新者名を追加
        $validated['updated_user_name'] = Auth::user()->name;

        $CourseTeacher->update($validated);

        return redirect()->route('admin.course_teachers.index')->with('success', 'CourseTeacher更新完了');
    }

    public function destroy($id)
    {
        $courseTeacher = CourseTeacher::findOrFail($id);

        // 誰が削除したかをセット
        $courseTeacher->deleted_user_name = auth()->user()->name;

        // ここで保存してから削除
        $courseTeacher->save();

        // ソフトデリート
        $courseTeacher->delete();

        return redirect()->route('admin.course_teachers.index')->with('success', 'CourseTeacher削除完了');
    }

    private function checkCrudPermission()
    {
        $roleId = auth()->user()->role_id;

        // CRUD権限なしユーザー
        if (in_array($roleId, [1, 2, 3, 4])) {
            abort(403, 'アクセス権限がありません。');
        }

        // role 5 は制限付き
        if ($roleId == 5) {
            // course_teacher, reports, questions, agenda は OK
            $allowed = ['course_teacher', 'reports', 'questions', 'agenda'];
            $path = request()->path();
            $isAllowed = false;
            foreach ($allowed as $a) {
                if (str_contains($path, $a)) {
                    $isAllowed = true;
                    break;
                }
            }
            if (!$isAllowed) {
                abort(403, 'アクセス権限がありません。');
            }
        }
    }
}
