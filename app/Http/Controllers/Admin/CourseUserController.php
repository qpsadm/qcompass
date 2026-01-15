<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseUser;
use App\Models\User;
use App\Models\Course;

class CourseUserController extends Controller
{
    /**
     * 講座受講者一覧
     * 検索・ページネーション対応
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        // 許可するカラムを制限（重要）
        $sortable = [
            'user' => 'users.name',
            'course' => 'courses.course_name',
            'created_at' => 'course_users.created_at',
        ];

        $query = CourseUser::query()
            ->with(['user', 'course'])
            ->join('users', 'course_users.user_id', '=', 'users.id')
            ->join('courses', 'course_users.course_id', '=', 'courses.id');

        if (isset($sortable[$sort])) {
            $query->orderBy($sortable[$sort], $direction);
        }

        $courseUsers = $query
            ->select('course_users.*')
            ->paginate(20)
            ->withQueryString();

        return view('admin.course_users.index', compact('courseUsers', 'sort', 'direction'));
    }


    public function create()
    {
        return view('admin.course_users.create', [
            'users'   => User::where('role_id', '>=', 4)->get(),
            'courses' => Course::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        CourseUser::create($validated);

        return redirect()
            ->route('admin.course_users.index')
            ->with('success', '受講者を登録しました');
    }

    public function show($id)
    {
        $courseUser = CourseUser::with(['user', 'course'])->findOrFail($id);

        return view('admin.course_users.show', compact('courseUser'));
    }

    public function edit($id)
    {
        return view('admin.course_users.edit', [
            'courseUser' => CourseUser::findOrFail($id),
            'users'      => User::where('role_id', '>=', 4)->get(),
            'courses'    => Course::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $courseUser = CourseUser::findOrFail($id);

        $validated = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $courseUser->update($validated);

        return redirect()
            ->route('admin.course_users.index')
            ->with('success', '受講者を更新しました');
    }

    public function destroy($id)
    {
        CourseUser::findOrFail($id)->delete();

        return redirect()
            ->route('admin.course_users.index')
            ->with('success', '受講者を削除しました');
    }
}