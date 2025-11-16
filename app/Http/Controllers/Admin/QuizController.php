<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable',
            'title' => 'nullable',
            'description' => 'nullable',
            'course_id' => 'nullable',
            'agenda_id' => 'nullable',
            'type' => 'nullable',
            'time_limit' => 'nullable',
            'total_score' => 'nullable',
            'passing_score' => 'nullable',
            'random_order' => 'nullable',
            'active_from' => 'nullable',
            'active_to' => 'nullable',
            'created_by' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        Quiz::create($validated);
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz作成完了');
    }

    public function show($id)
    {
        $Quiz = Quiz::findOrFail($id);
        return view('admin.quizzes.show', compact('Quiz'));
    }

    public function edit($id)
    {
        $Quiz = Quiz::findOrFail($id);
        return view('admin.quizzes.edit', compact('Quiz'));
    }

    public function update(Request $request, $id)
    {
        $Quiz = Quiz::findOrFail($id);
        $validated = $request->validate([
            'code' => 'nullable',
            'title' => 'nullable',
            'description' => 'nullable',
            'course_id' => 'nullable',
            'agenda_id' => 'nullable',
            'type' => 'nullable',
            'time_limit' => 'nullable',
            'total_score' => 'nullable',
            'passing_score' => 'nullable',
            'random_order' => 'nullable',
            'active_from' => 'nullable',
            'active_to' => 'nullable',
            'created_by' => 'nullable',
            'deleted_at' => 'nullable',
        ]);
        $Quiz->update($validated);
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz更新完了');
    }

    public function destroy($id)
    {
        Quiz::findOrFail($id)->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz削除完了');
    }

    public function listForUser()
    {
        $quizzes = Quiz::all();

        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function takeQuiz(Quiz $quiz)
    {
        $questions = $quiz->questions()->where('is_show', true)
            ->with('choices')->get();
        if ($quiz->random_order) {
            $questions = $questions->shuffle();
        }
        return view('admin.quizzes.take', compact('quiz', 'questions'));
    }

    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $answers = $request->input('answers', []);
        $score = 0;

        foreach ($quiz->questions as $question) {
            $correctChoices = $question->choices()->where('is_correct', true)->pluck('id')->toArray();
            $userAnswer = $answers[$question->id] ?? [];
            if (is_array($userAnswer)) sort($userAnswer);
            if ($correctChoices == ($userAnswer ?? [])) {
                $score += $question->score ?? 0;
            }
        }

        // TODO: QuizResult に保存する
        return view('admin.quizzes.result', compact('quiz', 'score'));
    }
}
