<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable',
            'name' => 'nullable',
            'tag_type' => 'nullable',
            'theme_color' => 'nullable',
            'description' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        Tag::create($validated);
        return redirect()->route('admin.tags.index')->with('success', 'Tag作成完了');
    }

    public function show($id)
    {
        $Tag = Tag::findOrFail($id);
        return view('admin.tags.show', compact('Tag'));
    }

    public function edit($id)
    {
        $Tag = Tag::findOrFail($id);
        return view('admin.tags.edit', compact('Tag'));
    }

    public function update(Request $request, $id)
    {
        $Tag = Tag::findOrFail($id);
        $validated = $request->validate([
            'code' => 'nullable',
            'name' => 'nullable',
            'tag_type' => 'nullable',
            'theme_color' => 'nullable',
            'description' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $Tag->update($validated);
        return redirect()->route('admin.tags.index')->with('success', 'Tag更新完了');
    }

    public function destroy($id)
    {
        Tag::findOrFail($id)->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag削除完了');
    }
}
