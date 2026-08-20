<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseTeacher;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseTeacherController extends Controller
{
    public function index(Request $request)
    {
        $courseId   = $request->input('course_id');   // 講座IDフィルタ
        $search     = $request->input('search');

        // 並び替えパラメータ
        $sort = $request->get('sort', 'id');          // デフォルト No.
        $direction = $request->get('direction', 'asc'); // asc / desc

        // ソート可能カラム（安全対策）
        $allowedSorts = ['id', 'course_id', 'user_id', 'is_show', 'updated_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        $course_teachers = CourseTeacher::query()
            ->with(['course', 'user']);

        // 🔍 検索
        if ($search) {
            $course_teachers->where(function ($q) use ($search) {
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
            $course_teachers->whereHas('course', function ($q) use ($courseId) {
                $q->where('courses.id', $courseId);
            });
        }

        $course_teachers = $course_teachers
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->onEachSide(1);         //左にあるページネーションのボタン数を減らす;

        // プルダウン用講座一覧
        $courses = Course::where('is_show', 1)
            ->orderBy('id', 'desc')->get();

        return view(
            'admin.course_teachers.index',
            compact(
                'courses',
                'course_teachers',
                'sort',
                'direction'
            )
        );
    }

    public function create()
    {
        $users = User::where('role_id', '>=', 4)->get();
        $courses = Course::where('is_show', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.course_teachers.create', compact('users', 'courses'));
    }

    /**
     * ✅ 新規作成（削除済みがあれば復活）
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'role_in_course' => 'required|integer',
        ]);

        $validated['created_user_name'] = Auth::user()->name;
        $validated['updated_user_name'] = Auth::user()->name;

        // 🔍 削除済み含めて既存チェック
        $existing = CourseTeacher::withTrashed()
            ->where('course_id', $validated['course_id'])
            ->where('user_id', $validated['user_id'])
            ->first();

        if ($existing) {

            // ❌ すでに有効なデータがある
            if (!$existing->trashed()) {
                return back()
                    ->withErrors(['user_id' => 'この講座には既にこの講師が登録されています'])
                    ->withInput();
            }

            // ♻ 削除済み → 復活
            $existing->restore();
            $existing->update([
                'role_in_course' => $validated['role_in_course'],
                'updated_user_name' => Auth::user()->name,
                'deleted_user_name' => null,
            ]);

            return redirect()
                ->route('admin.course_teachers.index')
                ->with('success', '削除済みの講師を復活しました');
        }

        // 🆕 完全新規
        CourseTeacher::create($validated);

        return redirect()
            ->route('admin.course_teachers.index')
            ->with('success', 'CourseTeacherを作成しました');
    }

    public function edit($id)
    {
        $CourseTeacher = CourseTeacher::findOrFail($id);
        $courses = Course::orderBy('course_name', 'asc')->get();
        $users = User::all();

        return view('admin.course_teachers.edit', compact('CourseTeacher', 'courses', 'users'));
    }

    /**
     * ✅ 更新（削除済みと競合したら復活させる）
     */
    public function update(Request $request, $id)
    {
        $CourseTeacher = CourseTeacher::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'role_in_course' => 'required|integer',
        ]);

        $validated['updated_user_name'] = Auth::user()->name;

        // 🔍 同じ組み合わせ（自分以外）
        $existing = CourseTeacher::withTrashed()
            ->where('course_id', $validated['course_id'])
            ->where('user_id', $validated['user_id'])
            ->where('id', '!=', $CourseTeacher->id)
            ->first();

        if ($existing) {

            if ($existing->trashed()) {
                // ♻ 削除済みを復活
                $existing->restore();
                $existing->update([
                    'role_in_course' => $validated['role_in_course'],
                    'updated_user_name' => Auth::user()->name,
                    'deleted_user_name' => null,
                ]);

                // 元のレコードは削除
                $CourseTeacher->deleted_user_name = Auth::user()->name;
                $CourseTeacher->save();
                $CourseTeacher->delete();

                return redirect()
                    ->route('admin.course_teachers.index')
                    ->with('success', '削除済みの講師を復活させました');
            }

            return back()
                ->withErrors(['user_id' => 'この講座には既に同じ講師が登録されています'])
                ->withInput();
        }

        // 通常更新
        $CourseTeacher->update($validated);

        return redirect()
            ->route('admin.course_teachers.index')
            ->with('success', '講座講師情報を更新しました');
    }

    public function destroy($id)
    {
        $courseTeacher = CourseTeacher::findOrFail($id);
        $courseTeacher->deleted_user_name = Auth::user()->name;
        $courseTeacher->save();
        $courseTeacher->delete();

        return redirect()
            ->route('admin.course_teachers.index')
            ->with('success', 'CourseTeacher削除完了');
    }

    public function show($id)
    {
        $CourseTeacher = CourseTeacher::findOrFail($id);
        return view('admin.course_teachers.show', compact('CourseTeacher'));
    }
}