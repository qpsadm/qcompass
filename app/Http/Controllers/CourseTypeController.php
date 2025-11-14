<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseType;

class CourseTypeController extends Controller
{
    public function index()
    {
        $course_type = CourseType::all();
        return view('course_type.index', compact('course_type'));
    }

    public function create()
    {
        return view('course_type.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable',
        ]);
        CourseType::create($validated);
        return redirect()->route('course_type.index')->with('success', 'CourseType作成完了');
    }

    public function show($id)
    {
        $CourseType = CourseType::findOrFail($id);
        return view('course_type.show', compact('CourseType'));
    }

    public function edit($id)
    {
        $CourseType = CourseType::findOrFail($id);
        return view('course_type.edit', compact('CourseType'));
    }

    public function update(Request $request, $id)
    {
        $CourseType = CourseType::findOrFail($id);
        $validated = $request->validate([
            'name' => 'nullable',
        ]);
        $CourseType->update($validated);
        return redirect()->route('course_type.index')->with('success', 'CourseType更新完了');
    }

    public function destroy($id)
    {
        CourseType::findOrFail($id)->delete();
        return redirect()->route('course_type.index')->with('success', 'CourseType削除完了');
    }
}