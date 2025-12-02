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
        $courses = $user->courses; // すでにリレーションがある前提

        // 担当の講師を集める
        $teachers = collect();

        foreach ($courses as $course) {
            $courseTeachers = $course->teachers()
                ->whereHas('role', function ($q) {
                    $q->where('id', '>=', 4); // role_id >= 4 が講師
                })
                ->get();

            $teachers = $teachers->merge($courseTeachers);
        }

        // 重複を削除（同じ講師が複数講座担当の可能性）
        $teachers = $teachers->unique('id');

        return view('user.teacher.teachers_list', compact('teachers'));
    }


    /**
     * 先生詳細画面
     */
    public function show($teacherId)
    {
        $teacher = User::with('role')
            ->whereHas('role', function ($q) {
                $q->where('id', '>=', 4);
            })
            ->findOrFail($teacherId);

        return view('user.teacher.teachers_info', compact('teacher'));
    }
}
