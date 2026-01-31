<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizQuestion;

class QuizQuestionController extends Controller
{
    /**
     * 問題一覧表示
     * 指定されたクイズに紐づく問題を取得する
     */
    public function index(Quiz $quiz)
    {
        // クイズに紐づく問題を、選択肢付きで取得
        $quizQuestions = $quiz->questions()
            ->with('choices')
            ->get();

        return view('admin.quizzes.quiz_questions.index', compact('quiz', 'quizQuestions'));
    }

    /**
     * 問題作成画面表示
     */
    public function create(Quiz $quiz)
    {
        return view('admin.quizzes.quiz_questions.create', compact('quiz'));
    }

    /**
     * 問題登録処理
     */
    public function store(Request $request, Quiz $quiz)
    {
        // 入力バリデーション
        $request->validate([
            'question_text' => 'required|string',
            'score' => 'required|integer|min:0',
            'type' => 'required|in:single_2,single_4,multi,text',
            'choices' => 'required_unless:type,text|array|min:1',
            'correct_choice' => 'required_if:type,single_2,single_4|integer',
        ]);

        // 問題を作成（Quizと紐づく）
        $question = $quiz->questions()->create([
            'question_text' => $request->question_text,
            'score' => $request->score,
            'type' => $request->type,
        ]);

        // 記述式以外は選択肢を保存
        if ($request->type !== 'text') {

            // 単一選択（2択・4択）
            if (in_array($request->type, ['single_2', 'single_4'])) {
                foreach ($request->choices as $i => $choice) {
                    $question->choices()->create([
                        'choice_text' => $choice['choice_text'],
                        // 正解のインデックスと一致したものを正解にする
                        'is_correct' => ($i == $request->correct_choice),
                    ]);
                }

                // 複数選択
            } elseif ($request->type === 'multi') {
                foreach ($request->choices as $choice) {
                    $question->choices()->create([
                        'choice_text' => $choice['choice_text'],
                        // チェックされているものを正解にする
                        'is_correct' => isset($choice['is_correct']),
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.quizzes.show', $quiz->id)
            ->with('success', '問題を追加しました。');
    }

    /**
     * 問題編集画面表示
     */
    public function edit(Quiz $quiz, QuizQuestion $quiz_question)
    {
        // 選択肢も一緒に取得
        $quiz_question->load('choices');

        return view('admin.quizzes.quiz_questions.edit', [
            'quiz' => $quiz,
            'quizQuestion' => $quiz_question
        ]);
    }

    /**
     * 問題更新処理
     */
    public function update(Request $request, Quiz $quiz, QuizQuestion $quiz_question)
    {
        // 入力バリデーション
        $request->validate([
            'question_text' => 'required|string',
            'score' => 'required|integer|min:0',
            'type' => 'required|in:single_2,single_4,multi,text',
            'choices' => 'required_unless:type,text|array|min:1',
            'correct_choice' => 'required_if:type,single_2,single_4|integer',
        ]);

        // 問題内容を更新
        $quiz_question->update([
            'question_text' => $request->question_text,
            'score' => $request->score,
            'type' => $request->type,
        ]);

        // 既存の選択肢を一旦すべて削除
        $quiz_question->choices()->delete();

        // 記述式以外は選択肢を再作成
        if ($request->type !== 'text') {

            // 単一選択
            if (in_array($request->type, ['single_2', 'single_4'])) {
                foreach ($request->choices as $i => $choice) {
                    $quiz_question->choices()->create([
                        'choice_text' => $choice['choice_text'],
                        'is_correct' => ($i == $request->correct_choice),
                    ]);
                }

                // 複数選択
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

    /**
     * 問題削除処理
     */
    public function destroy(Quiz $quiz, QuizQuestion $quiz_question)
    {
        // 問題を削除（SoftDeleteの場合は論理削除）
        $quiz_question->delete();

        return redirect()
            ->route('admin.quizzes.show', $quiz->id)
            ->with('success', '問題を削除しました');
    }
}
