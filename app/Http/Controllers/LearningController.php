<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learning;

class LearningController extends Controller
{
    public function index()
    {
        $learning = Learning::all();
        return view('learning.index', compact('learning'));
    }

    public function create()
    {
        return view('learning.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'nullable',
            'name' => 'nullable',
            'author' => 'nullable',
            'publisher' => 'nullable',
            'publication_date' => 'nullable',
            'isbn' => 'nullable',
            'url' => 'nullable',
            'image' => 'nullable',
            'level' => 'nullable',
            'description' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        Learning::create($validated);
        return redirect()->route('learning.index')->with('success', 'Learning作成完了');
    }

    public function show($id)
    {
        $Learning = Learning::findOrFail($id);
        return view('learning.show', compact('Learning'));
    }

    public function edit($id)
    {
        $Learning = Learning::findOrFail($id);
        return view('learning.edit', compact('Learning'));
    }

    public function update(Request $request, $id)
    {
        $Learning = Learning::findOrFail($id);
        $validated = $request->validate([
            'type' => 'nullable',
            'name' => 'nullable',
            'author' => 'nullable',
            'publisher' => 'nullable',
            'publication_date' => 'nullable',
            'isbn' => 'nullable',
            'url' => 'nullable',
            'image' => 'nullable',
            'level' => 'nullable',
            'description' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $Learning->update($validated);
        return redirect()->route('learning.index')->with('success', 'Learning更新完了');
    }

    public function destroy($id)
    {
        Learning::findOrFail($id)->delete();
        return redirect()->route('learning.index')->with('success', 'Learning削除完了');
    }
}