<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use App\Models\QuizQuestionChoice;
use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        $types = [1 => '試験', 2 => 'アンケート', 3 => '練習'];
        return view('admin.quizzes.index', compact('quizzes', 'types'));
    }

    public function create()
    {
        $courses = Course::all();
        $quiz = new Quiz();;
        return view('admin.quizzes.create', compact('quiz', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'course_id' => 'nullable|integer|exists:courses,id',
            'type' => 'required|integer'
        ]);

        $quiz = Quiz::create([
            'title' => $validated['title'],
            'code' => 'Q-' . strtoupper(Str::random(6)),
            'description' => $request->input('description'),
            'course_id' => $validated['course_id'] ?? null,
            'type' => $validated['type'],
            'created_by' => Auth::id()
        ]);

        return redirect()->route('admin.quizzes.edit', $quiz->id)
            ->with('success', 'クイズ作成完了');
    }

    public function edit(Quiz $quiz)
    {
        $courses = Course::all();
        $questions = $quiz->quizQuestions()->with('choices')->get();
        return view('admin.quizzes.edit', compact('quiz', 'courses', 'questions'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'course_id' => 'nullable|integer|exists:courses,id',
            'type' => 'required|integer'
        ]);

        $quiz->update([
            'title' => $validated['title'],
            'description' => $request->input('description'),
            'course_id' => $validated['course_id'] ?? null,
            'type' => $validated['type']
        ]);

        return redirect()->back()->with('success', '更新完了');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete(); // 物理削除ではなくソフトデリート
        return redirect()->route('admin.quizzes.index')->with('success', '削除完了');
    }
    // GET: クイズプレイ画面
    public function play(Quiz $quiz)
    {
        $questions = $quiz->questions()->with('choices')->get();
        return view('admin.quizzes.play', compact('quiz', 'questions'));
    }

    public function submitPlay(Request $request, Quiz $quiz)
    {
        $user = auth()->user();

        // ============================
        // 1. 回答保存
        // ============================
        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'started_at' => now(),
            'status' => 1,
            'attempt_no' => QuizAttempt::where('quiz_id', $quiz->id)->where('user_id', $user->id)->count() + 1,
            'ip_address' => $request->ip(),
        ]);

        foreach ($request->answers as $questionId => $choiceId) {
            QuizAnswer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $questionId,
                'choice_id' => $choiceId,
                'user_id' => $user->id,
            ]);
        }

        // ============================
        // 2. 正解判定
        // ============================
        $totalCorrect = 0;

        $questions = $quiz->quizQuestions()->with('choices')->get();

        foreach ($questions as $question) {
            $userAnswer = $attempt->answers->firstWhere('question_id', $question->id);
            $correctChoice = $question->choices->firstWhere('is_correct', 1); // SQLite では 1 が true

            if ($userAnswer && $correctChoice && (int)$userAnswer->choice_id === (int)$correctChoice->id) {
                $totalCorrect++;
            }
        }

        $attempt->total_correct = $totalCorrect;
        $attempt->status = 2; // 完了
        $attempt->save();

        // ============================
        // 3. 結果画面へリダイレクト
        // ============================
        return redirect()
            ->route('admin.quizzes.result', ['attempt' => $attempt->id])
            ->with('success', '回答を送信しました！');
    }

    public function result($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz.quizQuestions.choices', 'answers', 'user'])->findOrFail($attemptId);

        $totalQuestions = $attempt->quiz->quizQuestions->count();
        $totalCorrect = $attempt->total_correct ?? 0;

        // パーセンテージ計算
        $percentage = $totalQuestions > 0 ? round(($totalCorrect / $totalQuestions) * 100, 1) : 0;

        // 合否判定（クイズに passing_score カラムがある場合）
        $passingScore = $attempt->quiz->passing_score ?? 70; // デフォルト70点
        $passFail = $percentage >= $passingScore ? '合格' : '不合格';

        return view('admin.quizzes.result', compact(
            'attempt',
            'totalQuestions',
            'totalCorrect',
            'percentage',
            'passFail'
        ));
    }

    public function show($id)
    {
        $quiz = Quiz::with([
            'questions.choices'
        ])->findOrFail($id);

        // total_score を自動計算して更新
        $autoScore = $quiz->questions->sum('score');

        if ($quiz->total_score !== $autoScore) {
            $quiz->total_score = $autoScore;
            $quiz->save();
        }

        return view('admin.quizzes.show', compact('quiz'));
    }
}
