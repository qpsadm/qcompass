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
        $questions = $quiz->questions()->with('choices')->get();
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
        $userAnswers = $request->input('answers', []); // [question_id => choice_id]

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

        // 保存しないので attempt は null のままでもOK
        return view('admin.quizzes.result', compact(
            'quiz',
            'results',
            'totalScore',
            'totalQuestions',
            'passingScore',
            'passFail'
        ));
    }

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
            $isCorrect = false;

            if ($correctChoice && $selectedChoiceId !== null) {
                $isCorrect = ((int)$correctChoice->id === (int)$selectedChoiceId);
                if ($isCorrect) {
                    $totalCorrect += $question->score ?? 1;
                }
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

        // ← ここで totalQuestions を追加
        $totalQuestions = $questions->count();

        return view('admin.quizzes.result', compact(
            'attempt',
            'results',
            'totalCorrect',
            'totalScore',
            'passingScore',
            'passFail',
            'totalQuestions' // 追加
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
