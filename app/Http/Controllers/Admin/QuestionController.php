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
        // 講座一覧（講師もリレーションで取得）
        $courses = Course::with('teachers')->get();

        // 講座ごとの講師配列を作成
        $coursesTeachers = [];
        foreach ($courses as $course) {
            $coursesTeachers[$course->id] = $course->teachers->map(function ($t) {
                return [
                    'id' => $t->id,
                    'name' => $t->name,
                ];
            });
        }

        return view('admin.questions.create', compact('courses', 'coursesTeachers'));
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
