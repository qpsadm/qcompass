<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Course;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.questions.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asker_id' => 'nullable',
            'agenda_id' => 'nullable',
            'course_id' => 'nullable',
            'title' => 'nullable',
            'responder_id' => 'nullable',
            'content' => 'nullable',
            'answer' => 'nullable',
            'is_show' => 'nullable',
            'deleted_at' => 'nullable',
        ]);

        Question::create($validated);

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question作成完了');
    }

    public function show($id)
    {
        $Question = Question::findOrFail($id);
        return view('admin.questions.show', compact('Question'));
    }

    public function edit($id)
    {
        $Question = Question::findOrFail($id);
        $courses = Course::all();
        return view('admin.questions.edit', compact('Question', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $Question = Question::findOrFail($id);
        $validated = $request->validate([
            'asker_id' => 'nullable',
            'agenda_id' => 'nullable',
            'course_id' => 'nullable',
            'title' => 'nullable',
            'responder_id' => 'nullable',
            'content' => 'nullable',
            'answer' => 'nullable',
            'is_show' => 'nullable',
            'deleted_at' => 'nullable',
        ]);

        $Question->update($validated);

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question更新完了');
    }

    public function destroy($id)
    {
        Question::findOrFail($id)->delete();

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question削除完了');
    }
}
