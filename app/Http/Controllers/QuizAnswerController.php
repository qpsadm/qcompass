<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizAnswer;

class QuizAnswerController extends Controller
{
    public function index()
    {
        $quiz_answers = QuizAnswer::all();
        return view('quiz_answers.index', compact('quiz_answers'));
    }

    public function create()
    {
        return view('quiz_answers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'attempt_id' => 'nullable',
            'question_id' => 'nullable',
            'choice_id' => 'nullable',
            'answer_text' => 'nullable',
            'is_correct' => 'nullable',
            'score' => 'nullable',
        ]);
        QuizAnswer::create($validated);
        return redirect()->route('quiz_answers.index')->with('success', 'QuizAnswer作成完了');
    }

    public function show($id)
    {
        $QuizAnswer = QuizAnswer::findOrFail($id);
        return view('quiz_answers.show', compact('QuizAnswer'));
    }

    public function edit($id)
    {
        $QuizAnswer = QuizAnswer::findOrFail($id);
        return view('quiz_answers.edit', compact('QuizAnswer'));
    }

    public function update(Request $request, $id)
    {
        $QuizAnswer = QuizAnswer::findOrFail($id);
        $validated = $request->validate([
            'attempt_id' => 'nullable',
            'question_id' => 'nullable',
            'choice_id' => 'nullable',
            'answer_text' => 'nullable',
            'is_correct' => 'nullable',
            'score' => 'nullable',
        ]);
        $QuizAnswer->update($validated);
        return redirect()->route('quiz_answers.index')->with('success', 'QuizAnswer更新完了');
    }

    public function destroy($id)
    {
        QuizAnswer::findOrFail($id)->delete();
        return redirect()->route('quiz_answers.index')->with('success', 'QuizAnswer削除完了');
    }
}