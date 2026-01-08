<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Category; // カテゴリモデル
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    // -------------------------
    // 一覧
    // -------------------------
    public function index()
    {
        // questionsの件数も取得
        $quizzes = Quiz::with('category')
            ->withCount('questions') // ここで問題数を取得
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.quizzes.index', compact('quizzes'));
    }



    // -------------------------
    // 作成フォーム
    // -------------------------
    public function create()
    {
        $categories = Category::all();
        $quiz = new Quiz();
        return view('admin.quizzes.create', compact('quiz', 'categories'));
    }

    // -------------------------
    // 作成処理
    // -------------------------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'category_id' => 'nullable|integer|exists:categories,id',
            'level' => 'nullable|integer|min:1|max:5',
            'type' => 'required|integer',
            'status' => 'nullable|integer',
            'is_show' => 'nullable|boolean',
        ]);

        $quiz = Quiz::create([
            'title' => $validated['title'],
            'code' => 'Q-' . strtoupper(Str::random(6)),
            'description' => $request->input('description'),
            'category_id' => $validated['category_id'] ?? null,
            'level' => $validated['level'] ?? null,
            'type' => $validated['type'],
            'status' => $validated['status'] ?? 2,
            'is_show' => $validated['is_show'] ?? 1,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('admin.quizzes.edit', $quiz->id)
            ->with('success', 'クイズ作成完了');
    }

    // -------------------------
    // 編集フォーム
    // -------------------------
    public function edit(Quiz $quiz)
    {
        $categories = Category::all();
        $questions = $quiz->questions()->with('choices')->get();
        return view('admin.quizzes.edit', compact('quiz', 'categories', 'questions'));
    }

    // -------------------------
    // 更新処理
    // -------------------------
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'category_id' => 'nullable|integer|exists:categories,id',
            'level' => 'nullable|integer|min:1|max:5',
            'type' => 'required|integer',
            'status' => 'nullable|integer',
            'is_show' => 'nullable|boolean',
        ]);

        $quiz->update([
            'title' => $validated['title'],
            'description' => $request->input('description'),
            'category_id' => $validated['category_id'] ?? null,
            'level' => $validated['level'] ?? null,
            'type' => $validated['type'],
            'status' => $validated['status'] ?? 2,
            'is_show' => $validated['is_show'] ?? 1,
        ]);

        // ★ここを変更
        return redirect()->route('admin.quizzes.show', $quiz->id)
            ->with('success', 'クイズを更新しました');
    }


    // -------------------------
    // 削除（ソフトデリート）
    // -------------------------
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', '削除完了');
    }

    // -------------------------
    // クイズプレイ画面
    // -------------------------
    public function play(Quiz $quiz)
    {
        $questions = $quiz->questions()->with('choices')->get();
        return view('admin.quizzes.play', compact('quiz', 'questions'));
    }

    // -------------------------
    // プレイ結果送信
    // -------------------------
    public function submitPlay(Request $request, Quiz $quiz)
    {
        $userAnswers = $request->input('answers', []);
        $questions = $quiz->questions()->with('choices')->get();
        $results = [];
        $totalScore = 0;

        foreach ($questions as $question) {
            $selectedChoiceId = $userAnswers[$question->id] ?? null;
            $correctChoice = $question->choices->firstWhere('is_correct', 1);
            $isCorrect = $correctChoice && $selectedChoiceId && ((int)$selectedChoiceId === (int)$correctChoice->id);

            if ($isCorrect) {
                $totalScore += $question->score ?? 1;
            }

            $results[] = [
                'question' => $question,
                'selectedChoiceId' => $selectedChoiceId,
                'correctChoice' => $correctChoice,
                'isCorrect' => $isCorrect
            ];
        }

        $totalQuestions = $questions->count();
        $passingScore = $quiz->passing_score ?? 70;
        $passFail = ($totalScore >= $passingScore) ? '合格' : '不合格';

        return view('admin.quizzes.result', compact(
            'quiz',
            'results',
            'totalScore',
            'totalQuestions',
            'passingScore',
            'passFail'
        ));
    }

    // -------------------------
    // 結果確認（attempt版）
    // -------------------------
    public function result($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz.questions.choices', 'answers', 'user'])->findOrFail($attemptId);
        $quiz = $attempt->quiz;
        $questions = $quiz->questions;

        $results = [];
        $totalCorrect = 0;

        foreach ($questions as $question) {
            $userAnswer = $attempt->answers->firstWhere('question_id', $question->id);
            $selectedChoiceId = $userAnswer ? $userAnswer->choice_id : null;
            $correctChoice = $question->choices->firstWhere('is_correct', 1);

            $isCorrect = $correctChoice && $selectedChoiceId !== null &&
                ((int)$correctChoice->id === (int)$selectedChoiceId);

            if ($isCorrect) {
                $totalCorrect += $question->score ?? 1;
            }

            $results[] = [
                'question' => $question,
                'userAnswer' => $selectedChoiceId,
                'isCorrect' => $isCorrect
            ];
        }

        $totalScore = $questions->sum('score');
        $passingScore = $quiz->passing_score ?? 70;
        $passFail = ($totalCorrect >= $passingScore) ? '合格' : '不合格';
        $totalQuestions = $questions->count();

        return view('admin.quizzes.result', compact(
            'attempt',
            'results',
            'totalCorrect',
            'totalScore',
            'passingScore',
            'passFail',
            'totalQuestions'
        ));
    }

    // -------------------------
    // 詳細表示
    // -------------------------
    public function show($id)
    {
        $quiz = Quiz::with(['questions.choices'])->findOrFail($id);
        $autoScore = $quiz->questions->sum('score');

        if ($quiz->total_score !== $autoScore) {
            $quiz->total_score = $autoScore;
            $quiz->save();
        }

        return view('admin.quizzes.show', compact('quiz'));
    }
}
