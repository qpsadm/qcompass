<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Course;
use App\Models\User;
use App\Models\Tag;

class QuestionController extends Controller
{

    private function checkCrudPermission()
    {
        $roleId = auth()->user()->role_id;

        // role 4: 閲覧のみ
        if ($roleId == 4) {
            $editableRoutes = ['create', 'store', 'edit', 'update', 'destroy'];
            foreach ($editableRoutes as $route) {
                if (\Route::currentRouteAction() && str_contains(\Route::currentRouteAction(), $route)) {
                    abort(403, 'アクセス権限がありません。');
                }
            }
        }

        // role 5: 制限付き編集可
        if ($roleId == 5) {
            $allowed = ['questions', 'reports', 'course_teacher', 'agenda'];
            $path = request()->path();
            foreach ($allowed as $a) {
                if (str_contains($path, $a)) {
                    return; // OK
                }
            }
            abort(403, 'アクセス権限がありません。');
        }
    }

    // 一覧
    public function index()
    {
        $questions = Question::with(['course', 'responder', 'tag'])->paginate(20);
        return view('admin.questions.index', compact('questions'));
    }

    // 作成画面
    public function create()
    {
        $courses = Course::with('teachers')->get(); // 講座情報を取得
        $coursesTeachers = []; // 講座に紐づく教師情報を格納する配列

        // 各講座に紐づく教師情報を整理
        foreach ($courses as $course) {
            $coursesTeachers[$course->id] = $course->teachers->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                ];
            });
        }

        $tags = Tag::all(); // タグ情報を取得

        // ビューに必要なデータを渡す
        return view('admin.questions.create', compact('courses', 'tags', 'coursesTeachers'));
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

        Question::create($validated); // 質問を作成

        return redirect()->route('admin.questions.index')->with('success', '質問を作成しました');
    }

    // 編集画面
    public function edit(Question $question)
    {
        // 編集するために講座とタグを取得
        $courses = Course::with('teachers')->get();
        $tags = Tag::all();

        // 各講座に紐づく教師情報を整理
        $coursesTeachers = [];
        foreach ($courses as $course) {
            $coursesTeachers[$course->id] = $course->teachers->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                ];
            });
        }

        // ビューに必要なデータを渡す
        return view('admin.questions.edit', compact('question', 'courses', 'tags', 'coursesTeachers'));
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

        $question->update($validated); // 質問を更新

        return redirect()->route('admin.questions.index')->with('success', '質問を更新しました');
    }

    // 詳細
    public function show($id)
    {
        $question = Question::findOrFail($id);  // 質問IDで質問を取得
        return view('admin.questions.show', compact('question'));  // 質問をビューに渡す
    }

    // 削除
    public function destroy(Question $question)
    {
        $question->delete(); // 質問を削除
        return redirect()->route('admin.questions.index')->with('success', '質問を削除しました');
    }
}
