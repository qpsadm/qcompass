<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CourseCategoryController extends Controller
{

    public function index()
    {
        $courses = \App\Models\Course::with('categories')->get();

        return view('admin.course_category.index', compact('courses'));
    }

    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        $categories = Category::all();

        // 講座に紐づくカテゴリIDの配列
        $selectedCategories = $course->categories()->pluck('categories.id')->toArray();

        return view('admin.course_category.create', compact('course', 'categories', 'selectedCategories'));
    }

    public function store(Request $request)
    {
        $courseId = $request->course_id;
        $categoryIds = $request->category_ids ?? [];

        // 既存の紐付けを削除
        CourseCategory::where('course_id', $courseId)->delete();

        foreach ($categoryIds as $categoryId) {
            CourseCategory::create([
                'course_id'          => $courseId,
                'category_id'        => $categoryId,
                'note'               => $request->note,
                'is_show'            => $request->is_show,
                'created_user_name'  => Auth::user()->name,
            ]);
        }

        // 講座カテゴリ一覧ページにリダイレクト
        return redirect()->route('admin.course_category.index')
            ->with('success', 'カテゴリ設定を更新しました');
    }



    public function show($id)
    {
        $CourseCategory = CourseCategory::findOrFail($id);
        return view('admin.course_category.show', compact('CourseCategory'));
    }

    public function edit($id)
    {
        $CourseCategory = CourseCategory::findOrFail($id);
        return view('admin.course_category.edit', compact('CourseCategory'));
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
        return redirect()->route('admin.course_category.index')->with('success', 'CourseCategory更新完了');
    }

    public function destroy($id)
    {
        CourseCategory::findOrFail($id)->delete();
        return redirect()->route('admin.course_category.index')->with('success', 'CourseCategory削除完了');
    }
}
