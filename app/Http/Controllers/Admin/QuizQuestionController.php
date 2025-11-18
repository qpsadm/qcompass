<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionChoice;

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
                ]);
            }
        }

        // ここを変更：一覧ページにリダイレクト
        return redirect()->route('admin.quizzes.quiz_questions.index', $quiz->id)
            ->with('success', '問題を追加しました');
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
