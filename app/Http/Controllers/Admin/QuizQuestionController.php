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
        $quizQuestions = $quiz->questions()->with('choices')->get();
        return view('admin.quizzes.quiz_questions.index', compact('quiz', 'quizQuestions'));
    }

    public function create(Quiz $quiz)
    {
        return view('admin.quizzes.quiz_questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_text' => 'required|string',
            'score' => 'required|integer|min:0',
            'type' => 'required|in:single_2,single_4,multi,text',
            'choices' => 'required_unless:type,text|array|min:1',
            'correct_choice' => 'required_if:type,single_2,single_4|integer',
        ]);

        $question = $quiz->questions()->create([
            'question_text' => $request->question_text,
            'score' => $request->score,
            'type' => $request->type,
        ]);

        if ($request->type !== 'text') {

            // 単一選択（2択・4択）
            if (in_array($request->type, ['single_2', 'single_4'])) {
                foreach ($request->choices as $i => $choice) {
                    $question->choices()->create([
                        'choice_text' => $choice['choice_text'],
                        'is_correct' => ($i == $request->correct_choice),
                    ]);
                }

                // 複数選択
            } elseif ($request->type === 'multi') {
                foreach ($request->choices as $choice) {
                    $question->choices()->create([
                        'choice_text' => $choice['choice_text'],
                        'is_correct' => isset($choice['is_correct']),
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.quizzes.show', $quiz->id)
            ->with('success', '問題を追加しました。');
    }

    public function edit(Quiz $quiz, QuizQuestion $quiz_question)
    {
        $quiz_question->load('choices');

        return view('admin.quizzes.quiz_questions.edit', [
            'quiz' => $quiz,
            'quizQuestion' => $quiz_question
        ]);
    }

    public function update(Request $request, Quiz $quiz, QuizQuestion $quiz_question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'score' => 'required|integer|min:0',
            'type' => 'required|in:single_2,single_4,multi,text',
            'choices' => 'required_unless:type,text|array|min:1',
            'correct_choice' => 'required_if:type,single_2,single_4|integer',
        ]);

        $quiz_question->update([
            'question_text' => $request->question_text,
            'score' => $request->score,
            'type' => $request->type,
        ]);

        // 選択肢は全削除 → 再作成
        $quiz_question->choices()->delete();

        if ($request->type !== 'text') {

            if (in_array($request->type, ['single_2', 'single_4'])) {
                foreach ($request->choices as $i => $choice) {
                    $quiz_question->choices()->create([
                        'choice_text' => $choice['choice_text'],
                        'is_correct' => ($i == $request->correct_choice),
                    ]);
                }
            } elseif ($request->type === 'multi') {
                foreach ($request->choices as $choice) {
                    $quiz_question->choices()->create([
                        'choice_text' => $choice['choice_text'],
                        'is_correct' => isset($choice['is_correct']),
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.quizzes.quiz_questions.index', $quiz->id)
            ->with('success', '問題を更新しました。');
    }

    public function destroy(Quiz $quiz, QuizQuestion $quiz_question)
    {
        $quiz_question->delete();

        return redirect()
            ->route('admin.quizzes.quiz_questions.index', $quiz->id)
            ->with('success', '問題を削除しました');
    }
}
