<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizQuestion;

class QuizQuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        // クイズに紐づく問題を取得（選択肢も一緒に）
        $quizQuestions = $quiz->quizQuestions()->with('choices')->get();

        return view('admin.quiz_questions.index', compact('quiz', 'quizQuestions'));
    }

    public function create(Quiz $quiz)
    {
        return view('admin.quiz_questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'score' => 'nullable|integer',
            'choices' => 'required|array|min:1',
        ]);

        $quizQuestion = $quiz->quizQuestions()->create([
            'question_text' => $validated['question_text'],
            'score' => $validated['score'] ?? 0,
            'is_show' => true,
            'order' => $quiz->quizQuestions()->count(),
        ]);

        foreach ($validated['choices'] as $choice) {
            $quizQuestion->choices()->create([
                'choice_text' => $choice['choice_text'],
                'is_correct' => $choice['is_correct'] ?? false,
            ]);
        }

        return redirect()->route('admin.quizzes.quiz_questions.index', $quiz->id)
            ->with('success', '問題追加完了');
    }

    public function edit(Quiz $quiz, QuizQuestion $quiz_question)
    {
        // 選択肢も一緒にロード
        $quiz_question->load('choices');

        return view('admin.quiz_questions.edit', [
            'quiz' => $quiz,
            'quizQuestion' => $quiz_question
        ]);
    }
    public function update(Request $request, Quiz $quiz, QuizQuestion $quiz_question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'score' => 'nullable|integer',
            'choices' => 'required|array|min:1',
        ]);

        $quiz_question->update([
            'question_text' => $validated['question_text'],
            'score' => $validated['score'] ?? 0,
        ]);

        // 古い選択肢を削除して再作成
        $quiz_question->choices()->delete();
        foreach ($validated['choices'] as $choice) {
            $quiz_question->choices()->create([
                'choice_text' => $choice['choice_text'],
                'is_correct' => $choice['is_correct'] ?? false,
            ]);
        }

        return redirect()->route('admin.quizzes.quiz_questions.index', $quiz->id)
            ->with('success', '問題を更新しました');
    }
    public function destroy(Quiz $quiz, QuizQuestion $quiz_question)
    {
        $quiz_question->delete();

        return redirect()->route('admin.quizzes.quiz_questions.index', $quiz->id)
            ->with('success', '問題を削除しました');
    }

    // edit/update/destroy も同様に $quiz を親として受け取り処理
}
