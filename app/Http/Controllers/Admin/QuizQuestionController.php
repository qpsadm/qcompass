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

        return view('admin.quizzes.quiz_questions.index', compact('quiz', 'quizQuestions'));
    }

    public function create(Quiz $quiz)
    {
        return view('admin.quizzes.quiz_questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        // ============================
        // バリデーション
        // ============================
        $request->validate([
            'question_text' => 'required|string',
            'score' => 'required|integer|min:0',
            'type' => 'required|in:single_2,single_4,multi,text',
            'choices' => function ($attr, $value, $fail) use ($request) {
                $type = $request->type;
                if (in_array($type, ['single_2', 'single_4'])) {
                    $expected = $type === 'single_2' ? 2 : 4;
                    if (count($value) !== $expected) {
                        $fail("{$type} の場合、選択肢は {$expected} 個でなければなりません。");
                    }
                }
                if ($type === 'multi' && count($value) > 10) {
                    $fail('複数選択は最大10個までです。');
                }
            }
        ]);

        // ============================
        // 問題作成
        // ============================
        $question = $quiz->quizQuestions()->create([
            'question_text' => $request->question_text,
            'score' => $request->score,
            'type' => $request->type,
        ]);

        // 選択肢の作成（textタイプは無視）
        if ($request->type !== 'text' && $request->has('choices')) {
            foreach ($request->choices as $choiceData) {
                $question->choices()->create([
                    'choice_text' => $choiceData['choice_text'],
                    'is_correct' => !empty($choiceData['is_correct']),
                ]);
            }
        }

        return redirect()->route('admin.quizzes.quiz_questions.index', $quiz->id)
            ->with('success', '問題を追加しました。');
    }





    public function edit(Quiz $quiz, QuizQuestion $quiz_question)
    {
        // 選択肢も一緒にロード
        $quiz_question->load('choices');

        return view('admin.quizzes.quiz_questions.edit', [
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
