<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CourseCategory;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * 現在講座ID取得（なりすまし優先）
     */
    private function getCurrentCourseId(): int
    {
        if (session()->has('impersonator_course_id')) {
            return session('impersonator_course_id');
        }

        $courseId = session('course_id');
        if (!$courseId) {
            abort(404, '講座が選択されていません');
        }

        return $courseId;
    }

    /**
     * 講座に紐づくカテゴリIDリスト
     */
    private function getAccessibleCategoryIds(int $courseId): array
    {
        return DB::table('course_categories')
            ->where('course_id', $courseId)
            ->pluck('category_id')
            ->toArray();
    }

    /**
     * クイズ一覧（講座カテゴリ限定、削除済み除外）
     */
    public function index(Request $request)
    {
        $courseId = $this->getCurrentCourseId();
        $accessibleCategoryIds = $this->getAccessibleCategoryIds($courseId);

        $selectedCategoryId = $request->get('category_id');
        if ($selectedCategoryId && !in_array($selectedCategoryId, $accessibleCategoryIds)) {
            abort(404);
        }

        // カテゴリ一覧 + 件数
        $categories = DB::table('categories')
            ->whereIn('id', $accessibleCategoryIds)
            ->orderBy('sort')
            ->get()
            ->map(function ($cat) {
                $cat->quiz_count = DB::table('quizzes')
                    ->where('category_id', $cat->id)
                    ->where('is_show', 1)
                    ->whereNull('deleted_at')
                    ->count();
                return $cat;
            });

        // クイズ一覧
        $quizzes = Quiz::where('is_show', 1)
            ->whereIn('category_id', $accessibleCategoryIds)
            ->whereNull('deleted_at')
            ->when($selectedCategoryId, fn($q) => $q->where('category_id', $selectedCategoryId))
            ->withCount('questions')
            ->orderBy('updated_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $selectedCategoryName = $selectedCategoryId
            ? $categories->firstWhere('id', $selectedCategoryId)?->name
            : null;

        return view('user.quizzes.index', compact(
            'categories',
            'quizzes',
            'selectedCategoryId',
            'selectedCategoryName'
        ));
    }

    /**
     * クイズ表示（講座チェック＋削除済み問題除外）
     */
    public function show(Quiz $quiz)
    {
        $courseId = $this->getCurrentCourseId();
        $accessibleCategoryIds = $this->getAccessibleCategoryIds($courseId);

        if (!in_array($quiz->category_id, $accessibleCategoryIds) || $quiz->is_show != 1 || $quiz->deleted_at) {
            abort(404);
        }

        $questions = $quiz->questions()
            ->with('choices')
            ->where('is_show', 1)
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('user.quizzes.show', compact('quiz', 'questions'));
    }

    /**
     * 回答送信（DB保存なし、削除済み問題除外）
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $courseId = $this->getCurrentCourseId();
        $accessibleCategoryIds = $this->getAccessibleCategoryIds($courseId);

        if (!in_array($quiz->category_id, $accessibleCategoryIds) || $quiz->is_show != 1 || $quiz->deleted_at) {
            abort(404);
        }

        $questions = $quiz->questions()
            ->with('choices')
            ->where('is_show', 1)
            ->whereNull('deleted_at')
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
     * 結果表示（削除済み問題除外）
     */
    public function result(Quiz $quiz)
    {
        $courseId = $this->getCurrentCourseId();
        $accessibleCategoryIds = $this->getAccessibleCategoryIds($courseId);

        if (!in_array($quiz->category_id, $accessibleCategoryIds) || $quiz->is_show != 1 || $quiz->deleted_at) {
            abort(404);
        }

        $data = session("quiz_result_{$quiz->id}");
        if (!$data) {
            return redirect()->route('user.quizzes.show', $quiz);
        }

        $results = $data['results'];
        $correctCount = collect($results)->where('isCorrect', true)->count();
        $totalQuestions = count($results);
        $totalScore = $data['score'];

        $passFail = '不合格';
        if ($quiz->total_score > 0) {
            $percentage = ($totalScore / $quiz->total_score) * 100;
            $passFail = $percentage >= 70 ? '合格' : '不合格';
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
