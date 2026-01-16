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
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        // 許可するカラム
        $sortable = [
            'user' => 'users.name',
            'course' => 'courses.course_name',
            'created_at' => 'course_users.created_at',
        ];

        $query = CourseUser::query()
            ->with(['user', 'course'])
            ->join('users', 'course_users.user_id', '=', 'users.id')
            ->join('courses', 'course_users.course_id', '=', 'courses.id')
            ->where('users.role_id', 3); // 受講生のみ

        if (isset($sortable[$sort])) {
            $query->orderBy($sortable[$sort], $direction);
        }

        $courseUsers = $query
            ->select('course_users.*')
            ->paginate(20)
            ->withQueryString();

        return view('admin.course_users.index', compact('courseUsers', 'sort', 'direction'));
    }

    /**
     * 新規作成フォーム
     */
    public function create()
    {
        $users = User::where('role_id', 3) // 受講生のみ
            ->orderBy('name')
            ->get();

        $courses = Course::orderBy('course_name')->get();

        return view('admin.course_users.create', compact('users', 'courses'));
    }

    /**
     * 保存処理
     */
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

    /**
     * 編集フォーム
     */
    public function edit($id)
    {
        $courseUser = CourseUser::findOrFail($id);

        $users = User::where('role_id', 3) // 受講生のみ
            ->orWhere('id', $courseUser->user_id) // 現在の受講者も含める
            ->orderBy('name')
            ->get();

        $courses = Course::orderBy('course_name')->get();

        return view('admin.course_users.edit', compact('courseUser', 'users', 'courses'));
    }

    /**
     * 更新処理
     */
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

    /**
     * 削除処理
     */
    public function destroy($id)
    {
        $courseUser = CourseUser::findOrFail($id);
        $courseUser->delete();

        return redirect()
            ->route('admin.course_users.index')
            ->with('success', '受講者を削除しました');
    }

    /**
     * 詳細表示
     */
    public function show($id)
    {
        $courseUser = CourseUser::with(['user', 'course'])->findOrFail($id);

        return view('admin.course_users.show', compact('courseUser'));
    }
}
