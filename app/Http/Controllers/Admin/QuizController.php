<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();

        $types = [
            1 => '試験',     // exam
            2 => 'アンケート', // survey
            3 => '練習',     // practice
        ];

        return view('admin.quizzes.index', compact('quizzes', 'types'));
    }

    public function create()
    {
        // 新規作成用に空の Quiz モデルを渡す
        $Quiz = new \App\Models\Quiz();

        // 講座リストを取得（セレクトボックス用）
        $courses = \App\Models\Course::all();

        return view('admin.quizzes.create', compact('Quiz', 'courses'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'nullable|integer',
            'agenda_id' => 'nullable|integer',
            'type' => 'required|integer|in:0,1,2',
            'time_limit' => 'nullable|integer',
            'total_score' => 'nullable|integer',
            'passing_score' => 'nullable|integer',
            'active_from' => 'nullable|date',
            'active_to' => 'nullable|date',
        ]);

        $validated['created_by'] = Auth::id();
        Quiz::create($validated);
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz作成完了');
    }

    public function edit($id)
    {
        $Quiz = Quiz::findOrFail($id);
        return view('admin.quizzes.edit', compact('Quiz'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $validated = $request->validate([
            'code' => 'nullable',
            'title' => 'required',
            'description' => 'nullable',
            'course_id' => 'nullable',
            'agenda_id' => 'nullable',
            'type' => 'required|integer|in:0,1,2',
            'time_limit' => 'nullable',
            'total_score' => 'nullable',
            'passing_score' => 'nullable',
            'random_order' => 'nullable|boolean',
            'active_from' => 'nullable|date',
            'active_to' => 'nullable|date',
        ]);
        $quiz->update($validated);
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz更新完了');
    }

    public function destroy($id)
    {
        Quiz::findOrFail($id)->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz削除完了');
    }

    // -----------------------
    // 受験機能
    // -----------------------

    public function takeQuiz(Quiz $quiz)
    {
        $questions = $quiz->questions()->where('is_show', true)->with('choices')->get();
        if ($quiz->random_order) {
            $questions = $questions->shuffle();
        }

        return view('admin.quizzes.take', compact('quiz', 'questions'));
    }

    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $answers = $request->input('answers', []);

        DB::transaction(function () use ($quiz, $answers) {
            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'user_id' => Auth::id(),
                'started_at' => now(),
                'completed_at' => now(),
                'status' => 1,
                'attempt_no' => QuizAttempt::where('quiz_id', $quiz->id)->where('user_id', Auth::id())->count() + 1
            ]);

            $totalScore = 0;

            foreach ($quiz->questions as $question) {
                $userAnswer = $answers[$question->id] ?? [];
                $correctChoices = $question->choices()->where('is_correct', true)->pluck('id')->toArray();
                $isCorrect = null;
                $score = 0;

                if ($question->question_type !== 'text') {
                    if (is_array($userAnswer)) sort($userAnswer);
                    $isCorrect = $correctChoices == ($userAnswer ?? []);
                    $score = $isCorrect ? $question->score ?? 0 : 0;
                    $totalScore += $score;
                }

                QuizAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'choice_id' => is_array($userAnswer) ? implode(',', $userAnswer) : $userAnswer,
                    'answer_text' => $question->question_type == 'text' ? ($userAnswer ?? null) : null,
                    'is_correct' => $isCorrect,
                    'score' => $score
                ]);
            }

            $attempt->update(['score' => $totalScore]);
        });

        return redirect()->route('admin.quizzes.index')->with('success', '受験完了');
    }
}
