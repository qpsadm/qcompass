<?php

// app/Http/Controllers/Admin/CategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->with('childrenRecursive')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable',
            'name' => 'required',
            'parent_id' => 'nullable',
            'top_id' => 'nullable',
            'level' => 'nullable',
            'child_count' => 'nullable',
            'is_show' => 'nullable',
            'theme_color' => 'nullable',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'カテゴリー作成完了');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'code' => 'nullable',
            'name' => 'required',
            'parent_id' => 'nullable',
            'top_id' => 'nullable',
            'level' => 'nullable',
            'child_count' => 'nullable',
            'is_show' => 'nullable',
            'theme_color' => 'nullable',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'カテゴリー更新完了');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'カテゴリー削除完了');
    }
}
