<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseUser;

class CourseUserController extends Controller
{
    public function index()
    {
        $course_user = CourseUser::all();
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
        return view('admin.course_users.edit', compact('CourseUser'));
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
