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
        $courses = Course::with('categories')->get();
        return view('admin.course_category.index', compact('courses'));
    }

    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        $categories = Category::all();
        $selectedCategories = $course->categories()->pluck('categories.id')->toArray();

        return view('admin.course_category.create', compact('course', 'categories', 'selectedCategories'));
    }

    public function store(Request $request)
    {
        $courseId = $request->course_id;
        $categoryIds = $request->category_ids ?? [];

        foreach ($categoryIds as $categoryId) {
            // 論理削除を含めて既存レコードを確認
            $existing = CourseCategory::withTrashed()
                ->where('course_id', $courseId)
                ->where('category_id', $categoryId)
                ->first();

            if ($existing) {
                // 既存レコードが論理削除されていれば復活
                $existing->restore();

                // 更新情報を反映
                $existing->update([
                    'note' => $request->note,
                    'is_show' => $request->is_show,
                    'updated_user_name' => \Illuminate\Support\Facades\Auth::user()->name,
                ]);
            } else {
                // 新規作成
                CourseCategory::create([
                    'course_id' => $courseId,
                    'category_id' => $categoryId,
                    'note' => $request->note,
                    'is_show' => $request->is_show,
                    'created_user_name' => \Illuminate\Support\Facades\Auth::user()->name,
                ]);
            }
        }

        // 既存の紐付けで、送信されなかったカテゴリは削除
        CourseCategory::where('course_id', $courseId)
            ->whereNotIn('category_id', $categoryIds)
            ->get()
            ->each(function ($category) {
                $category->deleted_user_name = \Illuminate\Support\Facades\Auth::user()->name;
                $category->save();
                $category->delete();
            });

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

    public function update(Request $request, $courseId)
    {
        $categoryIds = $request->category_ids ?? [];

        foreach ($categoryIds as $categoryId) {
            // 論理削除済みも含めて確認
            $existing = CourseCategory::withTrashed()
                ->where('course_id', $courseId)
                ->where('category_id', $categoryId)
                ->first();

            if ($existing) {
                // 既存なら復活＆更新
                if ($existing->trashed()) {
                    $existing->restore();
                }
                $existing->update([
                    'note' => $request->note,
                    'is_show' => $request->is_show,
                    'updated_user_name' => \Illuminate\Support\Facades\Auth::user()->name,
                ]);
            } else {
                // 新規作成
                CourseCategory::create([
                    'course_id' => $courseId,
                    'category_id' => $categoryId,
                    'note' => $request->note,
                    'is_show' => $request->is_show,
                    'created_user_name' => \Illuminate\Support\Facades\Auth::user()->name,
                ]);
            }
        }

        // **既存のカテゴリを消さない**ので論理削除処理は省略

        return redirect()->route('admin.course_category.index')
            ->with('success', 'カテゴリ設定を更新しました');
    }


    public function destroy($id)
    {
        $CourseCategory::findOrFail($id)->delete();
        return redirect()->route('admin.course_category.index')->with('success', 'CourseCategory削除完了');
    }
}
