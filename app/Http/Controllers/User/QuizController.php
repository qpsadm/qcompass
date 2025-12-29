<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // クイズ一覧
    public function index()
    {
        $courseId = session('course_id');

        $quizzes = Quiz::where('course_id', $courseId)
            ->withCount('questions')
            ->get();

        return view('user.quizzes.index', compact('quizzes'));
    }

    // クイズ詳細・問題表示
    public function show(Quiz $quiz)
    {
        $courseId = session('course_id');
        if ($quiz->course_id != $courseId) abort(404);

        $questions = $quiz->questions()
            ->with('choices')
            ->where('is_show', 1)
            ->orderBy('order')
            ->get();

        return view('user.quizzes.show', compact('quiz', 'questions'));
    }

    // 回答送信
    public function submit(Request $request, Quiz $quiz)
    {
        $courseId = session('course_id');
        if ($quiz->course_id !== $courseId) {
            abort(404);
        }

        $answers = $request->input('answers', []);

        // 仮で採点（ラジオ問題のみ）
        $results = [];
        $score = 0;
        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = null;

            if ($question->type === 'radio' && $userAnswer) {
                $isCorrect = $userAnswer == $question->correct_choice_id;
                if ($isCorrect) $score += $question->score ?? 1;
            }

            $results[] = [
                'question' => $question,
                'userAnswer' => $userAnswer,
                'isCorrect' => $isCorrect
            ];
        }

        // 合計スコアをセッションに保存して結果ページへリダイレクト
        session([
            "quiz_{$quiz->id}_results" => $results,
            "quiz_{$quiz->id}_score" => $score
        ]);

        return redirect()->route('user.quizzes.result', $quiz);
    }



    public function result(Quiz $quiz)
    {
        $results = session("quiz_{$quiz->id}_results");
        $score = session("quiz_{$quiz->id}_score");

        if (!$results || $score === null) {
            abort(404);
        }

        return view('user.quizzes.result', compact('quiz', 'score', 'results'));
    }
}
