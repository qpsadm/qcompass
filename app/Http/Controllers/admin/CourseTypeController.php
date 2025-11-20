<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseType;

class CourseTypeController extends Controller
{
    public function index()
    {
        $course_type = CourseType::all();
        return view('admin.course_type.index', compact('course_type'));
    }

    public function create()
    {
        $courseTypes = CourseType::all();
        return view('admin.course_type.create', compact('courseTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable',
        ]);
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
        return view('admin.course_type.edit', compact('CourseType'));
    }

    public function update(Request $request, $id)
    {
        $CourseType = CourseType::findOrFail($id);
        $validated = $request->validate([
            'name' => 'nullable',
        ]);
        $CourseType->update($validated);
        return redirect()->route('admin.course_type.index')->with('success', 'CourseType更新完了');
    }

    public function destroy($id)
    {
        CourseType::findOrFail($id)->delete();
        return redirect()->route('admin.course_type.index')->with('success', 'CourseType削除完了');
    }
}
