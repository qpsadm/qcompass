<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizQuestionChoice;

class QuestionChoiceController extends Controller
{
    public function index()
    {
        $question_choices = QuizQuestionChoice::all();
        return view('question_choices.index', compact('question_choices'));
    }

    public function create()
    {
        return view('question_choices.create');
    }

    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'score' => 'nullable|integer',
            'type' => 'required|string',
            'choices' => 'nullable|array',
        ]);

        $question = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question_text' => $validated['question_text'],
            'question_type' => $validated['type'],
            'score' => $validated['score'] ?? 0,
        ]);

        if ($validated['type'] !== 'text' && !empty($validated['choices'])) {
            foreach ($validated['choices'] as $c) {
                QuizQuestionChoice::create([
                    'quiz_question_id' => $question->id,
                    'choice_text' => $c['choice_text'],
                    'is_correct' => $c['is_correct'] ?? 0,
                    // 'order' は削除
                ]);
            }
        }

        return redirect()->route('admin.quizzes.quiz_questions.create', $quiz->id)
            ->with('success', '問題を追加しました');
    }


    public function show($id)
    {
        $QuestionChoice = QuizQuestionChoice::findOrFail($id);
        return view('question_choices.show', compact('QuestionChoice'));
    }

    public function edit($id)
    {
        $QuestionChoice = QuizQuestionChoice::findOrFail($id);
        return view('question_choices.edit', compact('QuestionChoice'));
    }

    public function update(Request $request, $id)
    {
        $QuestionChoice = QuizQuestionChoice::findOrFail($id);
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
        QuizQuestionChoice::findOrFail($id)->delete();
        return redirect()->route('question_choices.index')->with('success', 'QuestionChoice削除完了');
    }
}
