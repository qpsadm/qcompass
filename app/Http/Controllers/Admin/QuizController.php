<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Question;
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
        $quiz = new Quiz();
        $courses = Course::all();
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
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', '削除完了');
    }
}
