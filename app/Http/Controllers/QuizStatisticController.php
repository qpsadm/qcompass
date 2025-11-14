<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizStatistic;

class QuizStatisticController extends Controller
{
    public function index()
    {
        $quiz_statistics = QuizStatistic::all();
        return view('quiz_statistics.index', compact('quiz_statistics'));
    }

    public function create()
    {
        return view('quiz_statistics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'nullable',
            'average_score' => 'nullable',
            'highest_score' => 'nullable',
            'attempts_count' => 'nullable',
        ]);
        QuizStatistic::create($validated);
        return redirect()->route('quiz_statistics.index')->with('success', 'QuizStatistic作成完了');
    }

    public function show($id)
    {
        $QuizStatistic = QuizStatistic::findOrFail($id);
        return view('quiz_statistics.show', compact('QuizStatistic'));
    }

    public function edit($id)
    {
        $QuizStatistic = QuizStatistic::findOrFail($id);
        return view('quiz_statistics.edit', compact('QuizStatistic'));
    }

    public function update(Request $request, $id)
    {
        $QuizStatistic = QuizStatistic::findOrFail($id);
        $validated = $request->validate([
            'quiz_id' => 'nullable',
            'average_score' => 'nullable',
            'highest_score' => 'nullable',
            'attempts_count' => 'nullable',
        ]);
        $QuizStatistic->update($validated);
        return redirect()->route('quiz_statistics.index')->with('success', 'QuizStatistic更新完了');
    }

    public function destroy($id)
    {
        QuizStatistic::findOrFail($id)->delete();
        return redirect()->route('quiz_statistics.index')->with('success', 'QuizStatistic削除完了');
    }
}