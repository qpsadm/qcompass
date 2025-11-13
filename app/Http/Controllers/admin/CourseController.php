<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth; // 追加

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
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
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);

        // 作成者IDを追加
        $validated['created_user_id'] = Auth::id();

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
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);

        // 更新者IDを追加
        $validated['updated_user_id'] = Auth::id();

        $Course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course更新完了');
    }

    public function destroy($id)
    {
        $Course = Course::findOrFail($id);

        // 削除者IDをセットしてソフトデリート
        $Course->deleted_user_id = Auth::id();
        $Course->save();

        $Course->delete(); // SoftDeletes が有効なら deleted_at がセットされる

        return redirect()->route('admin.courses.index')->with('success', 'Course削除完了');
    }
}