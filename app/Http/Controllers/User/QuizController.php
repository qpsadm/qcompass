<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    // クイズ一覧
    public function index()
    {
        $quizzes = Quiz::where('active', true)
            ->where(function ($q) {
                $q->whereNull('active_from')->orWhere('active_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('active_to')->orWhere('active_to', '>=', now());
            })
            ->get();

        return view('user.quizzes.index', compact('quizzes'));
    }

    // クイズ詳細・問題表示
    public function show(Quiz $quiz)
    {
        $questions = $quiz->quizQuestions()->with('choices')->get();

        return view('user.quizzes.show', compact('quiz', 'questions'));
    }

    // 回答送信
    public function submit(Request $request, Quiz $quiz)
    {
        $questions = $quiz->quizQuestions()->with('choices')->get();
        $results = [];
        $score = 0;

        foreach ($questions as $q) {
            $answer = $request->input('answers.' . $q->id);

            if ($q->question_type === 'text') {
                $isCorrect = null;
                $userAnswer = $answer;
            } else {
                $correctChoices = $q->choices->where('is_correct', 1)->pluck('id')->map(fn($id) => (string)$id)->toArray();

                if ($q->question_type === 'multi') {
                    $selected = array_map('strval', (array) $answer);
                    $isCorrect = empty(array_diff($correctChoices, $selected)) && empty(array_diff($selected, $correctChoices));
                    $userAnswer = $selected;
                } else {
                    $isCorrect = in_array((string)$answer, $correctChoices, true);
                    $userAnswer = $answer;
                }

                if ($isCorrect) $score += $q->score;
            }

            $results[] = [
                'question' => $q,
                'userAnswer' => $userAnswer,
                'isCorrect' => $isCorrect,
            ];
        }

        return view('user.quizzes.result', compact('quiz', 'results', 'score'));
    }
}
