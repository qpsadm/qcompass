<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('quizzes.create');
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
        return redirect()->route('quizzes.index')->with('success', 'Quiz作成完了');
    }

    public function show($id)
    {
        $Quiz = Quiz::findOrFail($id);
        return view('quizzes.show', compact('Quiz'));
    }

    public function edit($id)
    {
        $Quiz = Quiz::findOrFail($id);
        return view('quizzes.edit', compact('Quiz'));
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
        return redirect()->route('quizzes.index')->with('success', 'Quiz更新完了');
    }

    public function destroy($id)
    {
        Quiz::findOrFail($id)->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz削除完了');
    }
}