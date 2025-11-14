<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionChoice;

class QuestionChoiceController extends Controller
{
    public function index()
    {
        $question_choices = QuestionChoice::all();
        return view('question_choices.index', compact('question_choices'));
    }

    public function create()
    {
        return view('question_choices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'nullable',
            'choice_text' => 'nullable',
            'is_correct' => 'nullable',
            'order' => 'nullable',
        ]);
        QuestionChoice::create($validated);
        return redirect()->route('question_choices.index')->with('success', 'QuestionChoice作成完了');
    }

    public function show($id)
    {
        $QuestionChoice = QuestionChoice::findOrFail($id);
        return view('question_choices.show', compact('QuestionChoice'));
    }

    public function edit($id)
    {
        $QuestionChoice = QuestionChoice::findOrFail($id);
        return view('question_choices.edit', compact('QuestionChoice'));
    }

    public function update(Request $request, $id)
    {
        $QuestionChoice = QuestionChoice::findOrFail($id);
        $validated = $request->validate([
            'question_id' => 'nullable',
            'choice_text' => 'nullable',
            'is_correct' => 'nullable',
            'order' => 'nullable',
        ]);
        $QuestionChoice->update($validated);
        return redirect()->route('question_choices.index')->with('success', 'QuestionChoice更新完了');
    }

    public function destroy($id)
    {
        QuestionChoice::findOrFail($id)->delete();
        return redirect()->route('question_choices.index')->with('success', 'QuestionChoice削除完了');
    }
}