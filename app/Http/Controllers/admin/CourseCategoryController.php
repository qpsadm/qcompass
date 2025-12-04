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
    public function index(Request $request)
    {
        // ソート対象カラム（id or course_name）
        $sortColumn = $request->get('sort', 'id');

        // 昇順 or 降順
        $order = $request->get('order', 'desc');

        // 不正な値を防ぐ
        if (!in_array($sortColumn, ['id', 'course_name'])) {
            $sortColumn = 'id';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        // agenda が消える → with('categories') を付けて N+1 防止
        $courses = Course::with('categories')
            ->orderBy($sortColumn, $order)
            ->get();

        return view('admin.course_category.index', compact('courses', 'sortColumn', 'order'));
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
        $categoryIds = $request->input('category_ids', []);

        foreach ($categoryIds as $categoryId) {
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
                    'is_show' => $request->has('is_show') ? 1 : 0, // チェックなしは0
                    'updated_user_name' => auth()->user()->name,
                ]);
            } else {
                // 新規作成
                CourseCategory::create([
                    'course_id' => $courseId,
                    'category_id' => $categoryId,
                    'note' => $request->note,
                    'is_show' => $request->has('is_show') ? 1 : 0,
                    'created_user_name' => auth()->user()->name,
                ]);
            }
        }

        // 選択されなかったカテゴリを削除（ソフトデリート）
        CourseCategory::where('course_id', $courseId)
            ->whereNotIn('category_id', $categoryIds)
            ->get()
            ->each(function ($cat) {
                $cat->delete();
            });

        return redirect()->route('admin.course_category.edit', $courseId)
            ->with('success', 'カテゴリ設定を保存しました。');
    }



    public function show($id)
    {
        // そのまま編集ページにリダイレクトする場合
        return redirect()->route('admin.course_category.edit', $id);
    }

    public function edit($courseId)
    {
        $course = Course::with('categories')->findOrFail($courseId);
        $categories = Category::all();
        $selectedCategories = $course->categories->pluck('id')->toArray();

        return view('admin.course_category.edit', compact('course', 'categories', 'selectedCategories'));
    }

    public function update(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $categoryIds = $request->input('category_ids', []);
        $note = $request->note;
        $is_show = $request->has('is_show') ? 1 : 0;

        $syncData = [];
        foreach ($categoryIds as $categoryId) {
            $syncData[$categoryId] = [
                'note' => $note,
                'is_show' => $is_show,
                'updated_user_name' => auth()->user()->name,
            ];
        }

        // syncで既存と新規をまとめて更新
        $course->categories()->sync($syncData);

        return redirect()->route('admin.course_category.index')
            ->with('success', '講座カテゴリを更新しました。');
    }


    public function destroy($id)
    {
        $CourseCategory::findOrFail($id)->delete();
        return redirect()->route('admin.course_category.index')->with('success', 'CourseCategory削除完了');
    }
}