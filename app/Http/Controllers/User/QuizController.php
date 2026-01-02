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
        $courseId = (int) session('course_id'); // 型を int に揃える
        $quizzes = Quiz::where('course_id', $courseId)
            ->withCount('questions')
            ->get();

        return view('user.quizzes.index', compact('quizzes'));
    }

    // クイズ詳細・問題表示
    public function show(Quiz $quiz)
    {
        $courseId = (int) session('course_id');
        if ($quiz->course_id !== $courseId) abort(404);

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
        $userAnswers = $request->input('answers', []);
        $questions = $quiz->questions()->with('choices')->get();

        $results = [];
        $totalScore = 0;

        foreach ($questions as $question) {

            $userAnswer = $userAnswers[$question->id] ?? null;
            $isCorrect = null;

            // 記述式
            if ($question->type === 'text') {
                $isCorrect = null;

                // 単一選択（2択・4択）
            } elseif (in_array($question->type, ['single_2', 'single_4'])) {

                $correctId = $question->choices
                    ->where('is_correct', 1)
                    ->pluck('id')
                    ->first();

                $isCorrect = ($userAnswer !== null && (int)$userAnswer === (int)$correctId);

                // 複数選択（チェックボックス）
            } elseif ($question->type === 'multi') {

                // 正解ID配列
                $correctIds = $question->choices
                    ->where('is_correct', 1)
                    ->pluck('id')
                    ->map(fn($v) => (int)$v)
                    ->sort()
                    ->values()
                    ->toArray();

                // ユーザー回答ID配列
                $userIds = collect($userAnswer ?? [])
                    ->map(fn($v) => (int)$v)
                    ->sort()
                    ->values()
                    ->toArray();

                $isCorrect = ($userIds === $correctIds);
            }

            if ($isCorrect) {
                $totalScore += $question->score ?? 1;
            }

            $results[] = [
                'question'   => $question,
                'userAnswer' => $userAnswer,
                'isCorrect'  => $isCorrect,
            ];
        }

        $totalQuestions = $questions->count();
        $passingScore = $quiz->passing_score ?? 70;
        $passFail = ($totalScore >= $passingScore) ? '合格' : '不合格';

        return view('user.quizzes.result', compact(
            'quiz',
            'results',
            'totalScore',
            'totalQuestions',
            'passingScore',
            'passFail'
        ));
    }






    // 結果表示
    public function result(Quiz $quiz)
    {
        $results = session("quiz_{$quiz->id}_results");
        $score = session("quiz_{$quiz->id}_score");
        $totalScore = session("quiz_{$quiz->id}_total_score");

        if (!$results) abort(404);

        return view('user.quizzes.result', compact('quiz', 'results', 'score', 'totalScore'));
    }
}
