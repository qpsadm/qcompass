<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionTag;

class QuestionTagController extends Controller
{
    public function index()
    {
        $question_tag = QuestionTag::all();
        return view('question_tag.index', compact('question_tag'));
    }

    public function create()
    {
        return view('question_tag.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'nullable',
            'tag_id' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        QuestionTag::create($validated);
        return redirect()->route('question_tag.index')->with('success', 'QuestionTag作成完了');
    }

    public function show($id)
    {
        $QuestionTag = QuestionTag::findOrFail($id);
        return view('question_tag.show', compact('QuestionTag'));
    }

    public function edit($id)
    {
        $QuestionTag = QuestionTag::findOrFail($id);
        return view('question_tag.edit', compact('QuestionTag'));
    }

    public function update(Request $request, $id)
    {
        $QuestionTag = QuestionTag::findOrFail($id);
        $validated = $request->validate([
            'question_id' => 'nullable',
            'tag_id' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $QuestionTag->update($validated);
        return redirect()->route('question_tag.index')->with('success', 'QuestionTag更新完了');
    }

    public function destroy($id)
    {
        QuestionTag::findOrFail($id)->delete();
        return redirect()->route('question_tag.index')->with('success', 'QuestionTag削除完了');
    }
}