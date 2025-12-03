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
    public function index()
    {
        // 10件ずつページネーション
        $course_teachers = CourseTeacher::with(['course', 'user'])->paginate(10);

        return view('admin.course_teachers.index', compact('course_teachers'));
    }

    public function create()
    {
        $users = User::where('role_id', '>=', 4)->get();
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
        $validated['created_user_name'] = Auth::user()->name;

        CourseTeacher::create($validated);

        return redirect()->route('admin.course_teachers.index')->with('success', 'CourseTeacher作成完了');
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
        if (Auth::user()->role_id == 5) {
            abort(403, '権限がありません。');
        }

        $CourseTeacher = CourseTeacher::findOrFail($id);
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'role_in_course' => 'required|integer',
        ]);
        $validated['updated_user_name'] = Auth::user()->name;

        $CourseTeacher->update($validated);

        return redirect()->route('admin.course_teachers.index')->with('success', 'CourseTeacher更新完了');
    }

    public function destroy($id)
    {
        $courseTeacher = CourseTeacher::findOrFail($id);
        $courseTeacher->deleted_user_name = Auth::user()->name;
        $courseTeacher->save();
        $courseTeacher->delete();

        return redirect()->route('admin.course_teachers.index')->with('success', 'CourseTeacher削除完了');
    }

    public function show($id)
    {
        $CourseTeacher = CourseTeacher::findOrFail($id);
        return view('admin.course_teachers.show', compact('CourseTeacher'));
    }
}
