<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
            // Scout を使った検索
            $courses = Course::search($query)->paginate(10);
        } else {
            $courses = Course::paginate(10);
        }

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'nullable',
            'course_type_ID' => 'nullable',
            'Level_id' => 'nullable',
            'organizer_id' => 'nullable',
            'course_name' => 'nullable',
            'venue' => 'nullable',
            'application_date' => 'nullable',
            'certification_date' => 'nullable',
            'certification_number' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'total_hours' => 'nullable',
            'periods' => 'nullable',
            'start_time' => 'nullable',
            'finish_time' => 'nullable',
            'start_viewing' => 'nullable',
            'finish_viewing' => 'nullable',
            'plan_path' => 'nullable',
            'flier_path' => 'nullable',
            'capacity' => 'nullable',
            'entering' => 'nullable',
            'completed' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        Course::create($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Course作成完了');
    }

    public function show($id)
    {
        $Course = Course::findOrFail($id);
        return view('admin.courses.show', compact('Course'));
    }

    public function edit($id)
    {
        $Course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('Course'));
    }

    public function update(Request $request, $id)
    {
        $Course = Course::findOrFail($id);
        $validated = $request->validate([
            'course_code' => 'nullable',
            'course_type_ID' => 'nullable',
            'Level_id' => 'nullable',
            'organizer_id' => 'nullable',
            'course_name' => 'nullable',
            'venue' => 'nullable',
            'application_date' => 'nullable',
            'certification_date' => 'nullable',
            'certification_number' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'total_hours' => 'nullable',
            'periods' => 'nullable',
            'start_time' => 'nullable',
            'finish_time' => 'nullable',
            'start_viewing' => 'nullable',
            'finish_viewing' => 'nullable',
            'plan_path' => 'nullable',
            'flier_path' => 'nullable',
            'capacity' => 'nullable',
            'entering' => 'nullable',
            'completed' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        $Course->update($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Course更新完了');
    }

    public function destroy($id)
    {
        Course::findOrFail($id)->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course削除完了');
    }
}
