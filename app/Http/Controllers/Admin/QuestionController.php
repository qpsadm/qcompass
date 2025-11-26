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
    public function index()
    {
        $questions = Question::with('tags')->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $courses = Course::with('teachers')->get();

        $coursesTeachers = [];
        foreach ($courses as $course) {
            $coursesTeachers[$course->id] = $course->teachers->map(function ($t) {
                return [
                    'id' => $t->id,
                    'name' => $t->name,
                ];
            });
        }

        $tags = Tag::all();

        return view('admin.questions.create', compact('courses', 'coursesTeachers', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'    => 'required',
            'title'        => 'required|string|max:255',
            'responder_id' => 'required',
            'content'      => 'required|string',
            'answer'       => 'nullable|string',
            'is_show'      => 'nullable|boolean',
            'tags'         => 'nullable|array',
        ]);

        $question = Question::create($validated);

        // ✅ タグ登録（pivot + 作成者保存）
        if (!empty($request->tags)) {
            foreach ($request->tags as $tagId) {
                $question->tags()->attach($tagId, [
                    'created_user_name' => auth()->user()->name ?? 'system',
                ]);
            }
        }

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question作成完了');
    }

    public function show($id)
    {
        $Question = Question::with('tags')->findOrFail($id);
        return view('admin.questions.show', compact('Question'));
    }

    public function edit($id)
    {
        $Question = Question::with('tags')->findOrFail($id);

        $courses = Course::with(['teachers' => function ($q) {
            $q->where('role_id', '>=', 4)
                ->whereNull('users.deleted_at');
        }])->get();

        $coursesTeachers = [];
        foreach ($courses as $course) {
            $coursesTeachers[$course->id] = $course->teachers->map(function ($t) {
                return [
                    'id' => $t->id,
                    'name' => $t->name,
                ];
            });
        }

        $tags = Tag::all();

        return view('admin.questions.edit', compact('Question', 'courses', 'coursesTeachers', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $Question = Question::with('tags')->findOrFail($id);

        $validated = $request->validate([
            'asker_id' => 'nullable',
            'target_id' => 'nullable',
            'course_id' => 'nullable',
            'title' => 'nullable',
            'responder_id' => 'nullable',
            'content' => 'nullable',
            'answer' => 'nullable',
            'is_show' => 'nullable',
            'deleted_at' => 'nullable',
            'tags' => 'nullable|array',
        ]);

        $Question->update($validated);

        // ✅ タグ差分処理
        $currentTags = $Question->tags()->pluck('tags.id')->toArray();
        $newTags = $request->tags ?? [];

        // ✅ 削除されたタグ → soft delete + 削除者記録
        $toDelete = array_diff($currentTags, $newTags);
        foreach ($toDelete as $tagId) {
            $Question->tags()->updateExistingPivot($tagId, [
                'deleted_user_name' => auth()->user()->name ?? 'system',
                'deleted_at' => now(),
            ]);
        }

        // ✅ 新規タグ追加
        foreach ($newTags as $tagId) {
            $Question->tags()->syncWithoutDetaching([
                $tagId => [
                    'updated_user_name' => auth()->user()->name ?? 'system',
                ]
            ]);
        }

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question更新完了');
    }

    public function destroy($id)
    {
        $Question = Question::with('tags')->findOrFail($id);

        // ✅ pivot側 soft delete
        foreach ($Question->tags as $tag) {
            $Question->tags()->updateExistingPivot($tag->id, [
                'deleted_user_name' => auth()->user()->name ?? 'system',
                'deleted_at' => now(),
            ]);
        }

        $Question->delete();

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question削除完了');
    }
}
