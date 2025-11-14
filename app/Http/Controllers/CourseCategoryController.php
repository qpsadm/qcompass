<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseCategory;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $course_category = CourseCategory::all();
        return view('course_category.index', compact('course_category'));
    }

    public function create()
    {
        return view('course_category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'nullable',
            'category_id' => 'nullable',
            'note' => 'nullable',
            'is_show' => 'nullable',
        ]);
        CourseCategory::create($validated);
        return redirect()->route('course_category.index')->with('success', 'CourseCategory作成完了');
    }

    public function show($id)
    {
        $CourseCategory = CourseCategory::findOrFail($id);
        return view('course_category.show', compact('CourseCategory'));
    }

    public function edit($id)
    {
        $CourseCategory = CourseCategory::findOrFail($id);
        return view('course_category.edit', compact('CourseCategory'));
    }

    public function update(Request $request, $id)
    {
        $CourseCategory = CourseCategory::findOrFail($id);
        $validated = $request->validate([
            'course_id' => 'nullable',
            'category_id' => 'nullable',
            'note' => 'nullable',
            'is_show' => 'nullable',
        ]);
        $CourseCategory->update($validated);
        return redirect()->route('course_category.index')->with('success', 'CourseCategory更新完了');
    }

    public function destroy($id)
    {
        CourseCategory::findOrFail($id)->delete();
        return redirect()->route('course_category.index')->with('success', 'CourseCategory削除完了');
    }
}