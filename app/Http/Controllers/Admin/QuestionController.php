<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Course;
use App\Models\User;
use App\Models\Tag;

class QuestionsController extends Controller
{
    // 一覧
    public function index()
    {
        $questions = Question::with(['course', 'responder', 'tag'])->paginate(20);
        return view('admin.questions.index', compact('questions'));
    }

    // 作成画面
    public function create()
    {
        $courses = Course::with('teachers')->get();

        $coursesTeachers = [];
        foreach ($courses as $course) {
            $coursesTeachers[$course->id] = $course->teachers->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                ];
            });
        }


        $tags = Tag::all();

        return view('admin.questions.create', compact('courses', 'tags'));
    }

    // 保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'    => 'nullable|exists:courses,id',
            'title'        => 'required|string|max:255',
            'responder_id' => 'nullable|exists:users,id',
            'content'      => 'required|string',
            'answer'       => 'nullable|string',
            'tag_id'       => 'required|exists:tags,id', // ラジオ必須
            'is_show'      => 'nullable|boolean',
        ]);

        Question::create($validated);

        return redirect()->route('admin.questions.index')->with('success', '質問を作成しました');
    }

    // 編集画面
    public function edit(Question $question)
    {
        $courses = Course::with('teachers')->get();
        $tags = Tag::all();

        return view('admin.questions.edit', compact('question', 'courses', 'tags'));
    }

    // 更新
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'course_id'    => 'nullable|exists:courses,id',
            'title'        => 'required|string|max:255',
            'responder_id' => 'nullable|exists:users,id',
            'content'      => 'required|string',
            'answer'       => 'nullable|string',
            'tag_id'       => 'required|exists:tags,id',
            'is_show'      => 'nullable|boolean',
        ]);

        $question->update($validated);

        return redirect()->route('admin.questions.index')->with('success', '質問を更新しました');
    }

    // 削除
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', '質問を削除しました');
    }
}
