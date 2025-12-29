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
        // ユーザーの回答を取得 [question_id => choice_id]
        $userAnswers = $request->input('answers', []);

        $questions = $quiz->questions()->with('choices')->get();

        $results = [];
        $totalScore = 0;

        foreach ($questions as $question) {
            $selectedChoiceId = $userAnswers[$question->id] ?? null;

            // 正解選択肢
            $correctChoice = $question->choices->firstWhere('is_correct', 1);

            // 正誤判定
            if ($correctChoice) {
                $isCorrect = $selectedChoiceId && ((int)$selectedChoiceId === (int)$correctChoice->id);
            } else {
                // 記述式など正解設定がない場合
                $isCorrect = null;
            }

            if ($isCorrect) {
                $totalScore += $question->score ?? 1;
            }

            // ユーザー回答をテキストに変換して保持
            if ($selectedChoiceId) {
                $userAnswerText = optional($question->choices->firstWhere('id', $selectedChoiceId))->choice_text ?? $selectedChoiceId;
            } else {
                $userAnswerText = '未回答';
            }

            $results[] = [
                'question' => $question,
                'userAnswer' => $userAnswerText,
                'correctChoice' => $correctChoice ? $correctChoice->choice_text : null,
                'isCorrect' => $isCorrect,
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
