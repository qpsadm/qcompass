<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseTeacher;

class CourseTeacherController extends Controller
{
    public function index()
    {
        $course_teachers = CourseTeacher::all();
        return view('course_teachers.index', compact('course_teachers'));
    }

    public function create()
    {
        return view('course_teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'nullable',
            'user_id' => 'nullable',
            'role_in_course' => 'nullable',
        ]);
        CourseTeacher::create($validated);
        return redirect()->route('course_teachers.index')->with('success', 'CourseTeacher作成完了');
    }

    public function show($id)
    {
        $CourseTeacher = CourseTeacher::findOrFail($id);
        return view('course_teachers.show', compact('CourseTeacher'));
    }

    public function edit($id)
    {
        $CourseTeacher = CourseTeacher::findOrFail($id);
        return view('course_teachers.edit', compact('CourseTeacher'));
    }

    public function update(Request $request, $id)
    {
        $CourseTeacher = CourseTeacher::findOrFail($id);
        $validated = $request->validate([
            'course_id' => 'nullable',
            'user_id' => 'nullable',
            'role_in_course' => 'nullable',
        ]);
        $CourseTeacher->update($validated);
        return redirect()->route('course_teachers.index')->with('success', 'CourseTeacher更新完了');
    }

    public function destroy($id)
    {
        CourseTeacher::findOrFail($id)->delete();
        return redirect()->route('course_teachers.index')->with('success', 'CourseTeacher削除完了');
    }
}