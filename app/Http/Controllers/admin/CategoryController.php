<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // 一覧表示
    public function index()
    {
        // 親カテゴリのみ取得＋子を再帰取得
        $categories = Category::whereNull('parent_id')->with('childrenRecursive')->get();
        return view('admin.categories.index', compact('categories'));
    }
    // 作成フォーム
    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->with('childrenRecursive')
            ->get();

        return view('admin.categories.create', compact('categories'));
    }

    // 保存
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:categories,code',
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'is_show' => 'sometimes|boolean',
            'theme_color' => 'nullable|string|max:50',
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

        return redirect()->route('admin.categories.index')
            ->with('success', 'カテゴリーを作成しました');
    }

    // 編集フォーム
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    // 更新
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'is_show' => 'nullable|boolean',
            'theme_color' => 'nullable|string|max:50',
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

    public function destroy(Category $category)
    {
        $this->deleteCategoryRecursively($category);
        return redirect()->route('admin.categories.index')
            ->with('success', 'カテゴリーとその子カテゴリを削除しました');
    }

    protected function deleteCategoryRecursively(Category $category)
    {
        foreach ($category->childrenRecursive as $child) {
            $this->deleteCategoryRecursively($child);
        }
        $category->delete(); // SoftDelete
    }


    // 動的に子の数を取得
    public function getChildCountAttribute()
    {
        return $this->children()->count();
    }

    // 復元
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.categories.index')->with('success', 'カテゴリーを復元しました');
    }
}
