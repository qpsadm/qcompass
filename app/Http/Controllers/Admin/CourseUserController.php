<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseUser;
use App\Models\User;
use App\Models\Course;

class CourseUserController extends Controller
{
    public function index()
    {
        // user と course を一緒にロードする
        $course_user = CourseUser::with(['user', 'course'])->get();

        return view('admin.course_users.index', compact('course_user'));
    }

    public function create()
    {
        return view('admin.course_users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable',
            'course_id' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        CourseUser::create($validated);
        return redirect()->route('admin.course_users.index')->with('success', 'CourseUser作成完了');
    }

    public function show($id)
    {
        $CourseUser = CourseUser::findOrFail($id);
        return view('admin.course_users.show', compact('CourseUser'));
    }

    public function edit($id)
    {
        $CourseUser = CourseUser::findOrFail($id);

        // ユーザー一覧（role_id が 4 以上）
        $users = User::where('role_id', '>=', 4)->get();

        // 講座一覧
        $courses = Course::all();

        return view('admin.course_users.edit', compact('CourseUser', 'users', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $CourseUser = CourseUser::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'nullable',
            'course_id' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $CourseUser->update($validated);
        return redirect()->route('admin.course_users.index')->with('success', 'CourseUser更新完了');
    }

    public function destroy($id)
    {
        CourseUser::findOrFail($id)->delete();
        return redirect()->route('admin.course_users.index')->with('success', 'CourseUser削除完了');
    }
}
