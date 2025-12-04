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
        $courses = $user->courses->pluck('id')->toArray();

        if (empty($courseIds)) {
            $teachers = collect();
        } else {
            $teachers = User::with(['role', 'detail'])
                ->whereIn('id', function ($query) use ($courseIds) {
                    $query->select('user_id')
                          ->from('course_teachers')
                          ->whereIn('course_id', $courseIds);
                })
                ->get();
        }

        return view('user.teacher.teachers_list', compact('teachers'));
    {


        // その講座に紐づく CourseTeacher を取得 → 講師一覧
        $teachers = User::with(['role', 'detail'])
            // ->whereIn('id', function ($query) use ($courseIds) {
            //     $query->select('user_id')
            //         ->from('course_teachers')
            //         ->whereIn('course_id', $courseIds);
            // })
            ->findOrFail($teacherId);

        return view('user.teacher.teachers_list', compact('teachers'));

        // $teachers = collect();

        // foreach ($courses as $course) {
        //     $courseTeachers = $course->teachers()
        //         ->with(['role', 'detail']) // ← ★ユーザー詳細をロード
        //         ->whereHas('role', function ($q) {
        //             $q->where('id', '>=', 4); // role_id >= 4 が講師
        //         })
        //         ->get();

        //     $teachers = $teachers->merge($courseTeachers);
        // }

        // // 重複を削除
        // $teachers = $teachers->unique('id');

        // return view('user.teacher.teachers_list', compact('teachers'));
    }



    /**
     * 先生詳細画面
     */
    public function show($teacherId)
    {

        $teacher = User::with(['role', 'detail'])
            ->whereIn('id', function ($query) {
                $query->select('user_id')->from('course_teachers');
            })
            ->findOrFail($teacherId);

        return view('user.teacher.teachers_info', compact('teacher'));

        // $teacher = User::with(['role', 'detail'])
        //     ->whereHas('role', function ($q) {
        //         $q->where('id', '>=', 4);
        //     })
        //     ->findOrFail($teacherId);

        // return view('user.teacher.teachers_info', compact('teacher'));
    }
