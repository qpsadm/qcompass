<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CourseCategory;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * クイズ一覧（カテゴリ有無 両対応）
     */
    public function index()
    {
        $courseId = (int) session('course_id');

        /**
         * ① 講座に紐づくカテゴリIDを取得（中間テーブル）
         */
        $categoryIds = CourseCategory::where('course_id', $courseId)
            ->where('is_show', 1)
            ->pluck('category_id');

        /**
         * ② クイズが1件以上あるカテゴリのみ取得
         */
        $categories = Category::whereIn('id', $categoryIds)
            ->whereHas('quizzes', function ($q) {
                $q->where('is_show', 1);
            })
            ->with([
                'quizzes' => function ($q) {
                    $q->where('is_show', 1)
                        ->withCount('questions')
                        ->orderBy('id');
                }
            ])
            ->orderBy('order')
            ->get();

        /**
         * ③ 未分類クイズ
         */
        $uncategorizedQuizzes = Quiz::where('course_id', $courseId)
            ->whereNull('category_id')
            ->where('is_show', 1)
            ->withCount('questions')
            ->orderBy('id')
            ->get();

        return view('user.quizzes.index', compact(
            'categories',
            'uncategorizedQuizzes'
        ));
    }

    /**
     * クイズ表示
     */
    public function show(Quiz $quiz)
    {
        $courseId = (int) session('course_id');

        if (!$courseId || $quiz->is_show != 1) {
            abort(404);
        }

        $belongsToCourse = CourseCategory::where('course_id', $courseId)
            ->where('category_id', $quiz->category_id)
            ->exists();

        if (!$belongsToCourse) {
            abort(404);
        }

        $questions = $quiz->questions()
            ->with('choices')
            ->where('is_show', 1)
            ->orderBy('order')
            ->get();

        return view('user.quizzes.show', compact('quiz', 'questions'));
    }



    /**
     * 回答送信（DB保存なし）
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $courseId = (int) session('course_id');

        if (!$courseId || $quiz->is_show != 1) {
            abort(404);
        }

        $belongsToCourse = CourseCategory::where('course_id', $courseId)
            ->where('category_id', $quiz->category_id)
            ->exists();

        if (!$belongsToCourse) {
            abort(404);
        }

        $questions = $quiz->questions()
            ->with('choices')
            ->where('is_show', 1)
            ->get();

        $score = 0;
        $results = [];

        foreach ($questions as $question) {
            $userAnswer = $request->input("answers.{$question->id}");
            $isCorrect  = $question->isCorrect($userAnswer);

            if ($isCorrect) {
                $score += $question->score ?? 1;
            }

            $results[] = [
                'question'   => $question,
                'userAnswer' => $userAnswer,
                'isCorrect'  => $isCorrect,
            ];
        }

        session([
            "quiz_result_{$quiz->id}" => compact('score', 'results')
        ]);

        return redirect()->route('user.quizzes.result', $quiz);
    }


    /**
     * 結果表示
     */
    public function result(Quiz $quiz)
    {
        $data = session("quiz_result_{$quiz->id}");

        if (!$data) {
            return redirect()->route('user.quizzes.show', $quiz);
        }

        $results = $data['results'];

        // 正解数（isCorrect === true のみカウント）
        $correctCount = collect($results)
            ->where('isCorrect', true)
            ->count();

        // 全問題数
        $totalQuestions = count($results);

        // 合計得点
        $totalScore = $data['score'];

        // 合格判定（7割以上）
        if ($quiz->total_score > 0) {
            $percentage = ($totalScore / $quiz->total_score) * 100;
            $passFail = $percentage >= 70 ? '合格' : '不合格';
        } else {
            // 念のため満点未設定時のフォールバック
            $passFail = '不合格';
        }

        return view('user.quizzes.result', compact(
            'quiz',
            'results',
            'totalScore',
            'totalQuestions',
            'correctCount',
            'passFail'
        ));
    }
}
