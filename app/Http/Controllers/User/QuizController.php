<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionChoice;

class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        // 問題と選択肢をまとめて取得
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
                // 記述式（自由入力）
                $isCorrect = null;
                $userAnswer = $answer;
            } else {
                $correctChoices = $q->choices->where('is_correct', 1)->pluck('id')->map(fn($id) => (string)$id)->toArray();

                if ($q->question_type === 'multi') {
                    $selected = array_map('strval', (array) $answer); // 送信値を文字列化
                    // 正解と選択肢が完全一致か確認
                    $isCorrect = empty(array_diff($correctChoices, $selected)) && empty(array_diff($selected, $correctChoices));
                    $userAnswer = $selected;
                } else {
                    $isCorrect = in_array((string)$answer, $correctChoices, true);
                    $userAnswer = $answer;
                }

                if ($isCorrect) {
                    $score += $q->score;
                }
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
