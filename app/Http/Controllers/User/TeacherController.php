<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;

class TeacherController extends Controller
{
    /**
     * 自分の講座に紐づく先生一覧
     */
    public function index()
    {
        $user = auth()->user();

        // ユーザーが受講中の講座一覧
        $courses = $user->courses;

        $teachers = collect();

        foreach ($courses as $course) {
            $courseTeachers = $course->teachers()
                ->with(['role', 'detail']) // ← ★ユーザー詳細をロード
                ->whereHas('role', function ($q) {
                    $q->where('id', '>=', 4); // role_id >= 4 が講師
                })
                ->get();

            $teachers = $teachers->merge($courseTeachers);
        }

        // 重複を削除
        $teachers = $teachers->unique('id');

        return view('user.teacher.teachers_list', compact('teachers'));
    }



    /**
     * 先生詳細画面
     */
    public function show($teacherId)
    {
        $teacher = User::with(['role', 'detail'])
            ->whereHas('role', function ($q) {
                $q->where('id', '>=', 4);
            })
            ->findOrFail($teacherId);

        return view('user.teacher.teachers_info', compact('teacher'));
    }

    public function allTeachers()
    {
        $teachers = User::with(['role', 'detail'])
            ->whereHas('role', function ($q) {
                $q->whereIn('id', [5, 6, 8]);
            })
            ->get();

        return view('user.teacher.all_teachers_list', compact('teachers'));
    }

    public function frontShow($teacherId)
    {
        $teacher = User::with(['role', 'detail'])
            ->whereHas('role', function ($q) {
                $q->whereIn('id', [ 5, 6, 8]);
            })
            ->findOrFail($teacherId);

        return view('user.teacher.teachers_info', compact('teacher'));
    }
}
