<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // 通常一覧
    public function index()
    {
        $categories = Category::whereNull('parent_id')->with('childrenRecursive')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // 作成フォーム
    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('childrenRecursive')->get();
        return view('admin.categories.create', compact('categories'));
    }

    // 保存
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (\App\Models\Category::withTrashed()->where('code', $value)->exists()) {
                        $fail('同じコードのカテゴリーが既に存在します（ゴミ箱含む）');
                    }
                },
            ],
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'is_show' => 'sometimes|boolean',
        ]);

        $data['is_show'] = $request->boolean('is_show');

        if ($request->filled('parent_id')) {
            $parent = Category::find($request->parent_id);
            $data['level'] = $parent->level + 1;
            $data['top_id'] = $parent->top_id ?: $parent->id;
        } else {
            $data['level'] = 0;
            $data['top_id'] = 0;
            $data['parent_id'] = null;
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'カテゴリーを作成しました');
    }

    // 編集フォーム
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->with('childrenRecursive')->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    // 更新
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:categories,code,' . $category->id,
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'is_show' => 'nullable|boolean',
        ]);

        $data['is_show'] = $request->boolean('is_show');

        if ($request->filled('parent_id')) {
            $parent = Category::find($request->parent_id);
            $data['level'] = $parent->level + 1;
            $data['top_id'] = $parent->top_id ?: $parent->id;
        } else {
            $data['level'] = 0;
            $data['top_id'] = 0;
            $data['parent_id'] = null;
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'カテゴリーを更新しました');
    }

    // 削除（SoftDelete）
    public function destroy(Category $category)
    {
        $this->deleteCategoryRecursively($category);
        return redirect()->route('admin.categories.index')->with('success', 'カテゴリーと子カテゴリを削除しました');
    }

    protected function deleteCategoryRecursively(Category $category)
    {
        foreach ($category->childrenRecursive as $child) {
            $this->deleteCategoryRecursively($child);
        }
        $category->delete();
    }

    // ゴミ箱
    public function trash()
    {
        $categories = Category::onlyTrashed()
            ->whereNull('parent_id')
            ->with(['childrenRecursive' => function ($q) {
                $q->withTrashed();
            }])
            ->get();

        return view('admin.categories.trash', compact('categories'));
    }

    // 復元
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.categories.trash')->with('success', 'カテゴリーを復元しました');
    }

    // 完全削除
    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $this->forceDeleteCategoryRecursively($category);
        return redirect()->route('admin.categories.trash')->with('success', 'カテゴリーを完全削除しました');
    }

    protected function forceDeleteCategoryRecursively(Category $category)
    {
        foreach ($category->childrenRecursive()->withTrashed()->get() as $child) {
            $this->forceDeleteCategoryRecursively($child);
        }
        $category->forceDelete();
    }
}
