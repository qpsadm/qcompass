<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learning;

class LearningController extends Controller
{
    public function index()
    {
        $learnings = Learning::all();
        return view('learning.index', compact('learnings'));
    }

    public function create()
    {
        return view('learning.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:book,site,video,article',
            'name' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'isbn' => 'nullable|string|max:50',
            'url' => 'nullable|url|max:255',
            'image' => 'nullable|string|max:255',
            'level' => 'nullable|integer|min:1|max:5',
            'description' => 'nullable|string',
            'display_flag' => 'nullable|boolean',
        ]);

        Learning::create($validated);

        return redirect()->route('learning.index')->with('success', 'Learning作成完了');
    }

    public function show($id)
    {
        $learning = Learning::findOrFail($id);
        return view('learning.show', compact('learning'));
    }

    public function edit($id)
    {
        $learning = Learning::findOrFail($id);
        return view('learning.edit', compact('learning'));
    }

    public function update(Request $request, $id)
    {
        $learning = Learning::findOrFail($id);
        $validated = $request->validate([
            'type' => 'required|in:book,site,video,article',
            'name' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'isbn' => 'nullable|string|max:50',
            'url' => 'nullable|url|max:255',
            'image' => 'nullable|string|max:255',
            'level' => 'nullable|integer|min:1|max:5',
            'description' => 'nullable|string',
            'display_flag' => 'nullable|boolean',
        ]);
        $learning->update($validated);

        return redirect()->route('learning.index')->with('success', 'Learning更新完了');
    }

    public function destroy($id)
    {
        Learning::findOrFail($id)->delete();
        return redirect()->route('learning.index')->with('success', 'Learning削除完了');
    }
}