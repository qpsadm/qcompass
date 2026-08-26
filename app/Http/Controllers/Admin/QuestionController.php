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
    public function index(Request $request)
    {
        // 絞り込む・検索
        $courseId   = $request->input('course_id');   // 講座IDフィルタ
        $tagId   = $request->input('tag_id');   // タグIDフィルタ
        $search     = $request->input('search');

        // 並び替えパラメータ
        $sort = $request->get('sort', 'updated_at');  // デフォルト 更新日
        $direction = $request->get('direction', 'asc'); // asc / desc

        // ソート可能カラム（安全対策）
        $allowedSorts = ['id', 'course_id', 'tag_id', 'is_show', 'updated_at'];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'updated_at';
        }

        $questions = Question::query()->with(['course', 'tag']);

        // 🔍 検索
        if ($search) {
            $questions->where(function ($q) use ($search) {
                $q->Where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        // 🎓 タグ絞り込み
        if ($tagId) {
            $questions->whereHas('tag', function ($q) use ($tagId) {
                $q->where('tags.id', $tagId);
            });
        }

        // 🎓 講座絞り込み
        if ($courseId) {
            $questions->whereHas('course', function ($q) use ($courseId) {
                $q->where('courses.id', $courseId);
            });
        }

        $questions = $questions
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->onEachSide(1);         //左にあるページネーションのボタン数を減らす;


        // プルダウン用講座一覧
        $courses = Course::where('is_show', 1)
            ->orderBy('id', 'desc')->get();

        // プルダウン用タグ一覧
        $tags = Tag::where('is_show', 1)
            ->orderBy('id', 'asc')->get();

        return view(
            'admin.questions.index',
            compact(
                'courses',
                'tags',
                'questions',
                'sort',
                'direction'
            )
        );
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
        $question = Question::with(['course', 'responder', 'tag'])
            ->findOrFail($id);

        // 前の質問（IDが小さい中で最大）
        $prevQuestion = Question::where('id', '<', $question->id)
            ->orderBy('id', 'desc')
            ->first();

        // 次の質問（IDが大きい中で最小）
        $nextQuestion = Question::where('id', '>', $question->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('admin.questions.show', compact(
            'question',
            'prevQuestion',
            'nextQuestion'
        ));
    }


    // 削除
    public function destroy(Question $question)
    {
        $question->delete(); // 質問を削除
        return redirect()->route('admin.questions.index')->with('success', '質問を削除しました');
    }
}