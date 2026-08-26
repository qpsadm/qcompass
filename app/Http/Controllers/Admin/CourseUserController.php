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

        $courseId   = $request->input('course_id');   // 講座IDフィルタ
        $search     = $request->input('search');

        // 並び替えパラメータ
        $sort = $request->get('sort', 'course_id');          // デフォルト No.
        $direction = $request->get('direction', 'desc'); // asc / desc

        // ソート可能カラム（安全対策）
        $allowedSorts = ['id', 'course_id', 'user_id', 'is_show', 'updated_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        $courseUsers = CourseUser::query()
            ->with(['user', 'course']);

        // 🔍 検索
        if ($search) {
            $courseUsers->where(function ($q) use ($search) {
                // user リレーション先の name カラムを検索
                // もしコース名でも同時に検索したい場合は orWhereHas を追加
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('course', function ($courseQuery) use ($search) {
                    $courseQuery->where('course_name', 'like', "%{$search}%");
                });
            });
        }

        // 🎓 講座絞り込み
        if ($courseId) {
            $courseUsers->whereHas('course', function ($q) use ($courseId) {
                $q->where('courses.id', $courseId);
            });
        }

        $courseUsers = $courseUsers
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->onEachSide(1);         //左にあるページネーションのボタン数を減らす;


        // プルダウン用講座一覧
        $courses = Course::where('is_show', 1)
            ->orderBy('id', 'desc')->get();

        return view(
            'admin.course_users.index',
            compact(
                'courseUsers',
                'courses',
                'sort',
                'direction'
            )
        );
    }

    /**
     * 新規作成フォーム
     */
    public function create()
    {
        $users = User::where('role_id', 3) // 受講生のみ
            ->where('is_show', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->get();

        $courses = Course::where('is_show', '1')
            ->where('deleted_at', null)
            ->orderBy('created_at', 'desc')->get();

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
            ->where('is_show', '1')
            ->where('deleted_at', null)

            // ->orWhere('id', $courseUser->user_id) // 現在の受講者も含める
            ->orderBy('id', 'desc')
            ->get();

        $courses = Course::where('is_show', '1')
            ->where('deleted_at', null)
            ->orderBy('created_at', 'desc')->get();

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