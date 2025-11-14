<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizAttempt;

class QuizAttemptController extends Controller
{
    public function index()
    {
        $quiz_attempts = QuizAttempt::all();
        return view('quiz_attempts.index', compact('quiz_attempts'));
    }

    public function create()
    {
        return view('quiz_attempts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable',
            'quiz_id' => 'nullable',
            'started_at' => 'nullable',
            'completed_at' => 'nullable',
            'score' => 'nullable',
            'status' => 'nullable',
            'attempt_no' => 'nullable',
            'ip_address' => 'nullable',
        ]);
        QuizAttempt::create($validated);
        return redirect()->route('quiz_attempts.index')->with('success', 'QuizAttempt作成完了');
    }

    public function show($id)
    {
        $QuizAttempt = QuizAttempt::findOrFail($id);
        return view('quiz_attempts.show', compact('QuizAttempt'));
    }

    public function edit($id)
    {
        $QuizAttempt = QuizAttempt::findOrFail($id);
        return view('quiz_attempts.edit', compact('QuizAttempt'));
    }

    public function update(Request $request, $id)
    {
        $QuizAttempt = QuizAttempt::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'nullable',
            'quiz_id' => 'nullable',
            'started_at' => 'nullable',
            'completed_at' => 'nullable',
            'score' => 'nullable',
            'status' => 'nullable',
            'attempt_no' => 'nullable',
            'ip_address' => 'nullable',
        ]);
        $QuizAttempt->update($validated);
        return redirect()->route('quiz_attempts.index')->with('success', 'QuizAttempt更新完了');
    }

    public function destroy($id)
    {
        QuizAttempt::findOrFail($id)->delete();
        return redirect()->route('quiz_attempts.index')->with('success', 'QuizAttempt削除完了');
    }
}