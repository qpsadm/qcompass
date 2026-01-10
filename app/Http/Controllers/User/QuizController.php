<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CourseCategory;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * クイズ一覧（カテゴリ有無 両対応）
     */
    public function index(Request $request)
    {
        $selectedCategoryId = $request->get('category_id');

        // カテゴリ + 件数
        $categories = Category::withCount([
            'quizzes as quiz_count' => function ($q) {
                $q->where('is_show', 1)
                    ->whereNull('deleted_at');
            }
        ])
            ->whereHas('quizzes', function ($q) {
                $q->where('is_show', 1)
                    ->whereNull('deleted_at');
            })
            ->orderBy('order')
            ->get();


        // クイズ一覧
        $quizzes = Quiz::where('is_show', 1)
            ->when($selectedCategoryId, function ($q) use ($selectedCategoryId) {
                $q->where('category_id', $selectedCategoryId);
            })
            ->withCount('questions')
            ->paginate(10)
            ->withQueryString();

        // 選択中カテゴリ名
        $selectedCategoryName = null;
        if ($selectedCategoryId) {
            $selectedCategoryName = $categories
                ->firstWhere('id', $selectedCategoryId)?->name;
        }

        return view('user.quizzes.index', compact(
            'categories',
            'quizzes',
            'selectedCategoryId',
            'selectedCategoryName'
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
