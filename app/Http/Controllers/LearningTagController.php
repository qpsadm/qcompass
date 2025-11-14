<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearningTag;

class LearningTagController extends Controller
{
    public function index()
    {
        $learning_tag = LearningTag::all();
        return view('learning_tag.index', compact('learning_tag'));
    }

    public function create()
    {
        return view('learning_tag.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'learning_id' => 'nullable',
            'tag_id' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        LearningTag::create($validated);
        return redirect()->route('learning_tag.index')->with('success', 'LearningTag作成完了');
    }

    public function show($id)
    {
        $LearningTag = LearningTag::findOrFail($id);
        return view('learning_tag.show', compact('LearningTag'));
    }

    public function edit($id)
    {
        $LearningTag = LearningTag::findOrFail($id);
        return view('learning_tag.edit', compact('LearningTag'));
    }

    public function update(Request $request, $id)
    {
        $LearningTag = LearningTag::findOrFail($id);
        $validated = $request->validate([
            'learning_id' => 'nullable',
            'tag_id' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $LearningTag->update($validated);
        return redirect()->route('learning_tag.index')->with('success', 'LearningTag更新完了');
    }

    public function destroy($id)
    {
        LearningTag::findOrFail($id)->delete();
        return redirect()->route('learning_tag.index')->with('success', 'LearningTag削除完了');
    }
}