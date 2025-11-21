<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\Course;
use Illuminate\Http\Request;

class QuizResultController extends Controller
{
    public function courseResults($courseId)
    {
        // コース取得
        $course = Course::with('quizzes')->findOrFail($courseId);

        // クイズ取得（Collection で安全に扱えるようにする）
        $quizzes = $course->quizzes;

        // クイズID配列
        $quizIds = $quizzes->pluck('id');

        // 回答取得
        $answers = QuizAnswer::with('user', 'quiz')
            ->whereIn('quiz_id', $quizIds)
            ->get();

        // ユーザーごとの集計
        $results = $answers->groupBy('user_id')->map(function ($userAnswers) {
            $user = $userAnswers->first()->user;

            $totalScore = $userAnswers->sum('total_score');
            $maxScore   = $userAnswers->sum(fn($a) => $a->quiz->total_score);

            $accuracy = $maxScore > 0 ? round($totalScore / $maxScore * 100, 2) : 0;

            return [
                'user'        => $user,
                'count'       => $userAnswers->count(),
                'total_score' => $totalScore,
                'accuracy'    => $accuracy,
                'last_answer' => $userAnswers->sortByDesc('created_at')->first()->created_at,
            ];
        });

        // Collection に変換して Blade 側で isEmpty() を使えるように
        $results = collect($results);

        return view('admin.quizzes.quiz_results.course', [
            'course'  => $course,
            'results' => $results,
        ]);
    }
}
