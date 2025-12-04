<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * すべての講師一覧（重複なし、role_id >= 4、ページネーション対応）
     */
    public function index()
    {
        // course_teachers から全講師 user_id を取得
        $teacherIds = DB::table('course_teachers')
            ->distinct()
            ->pluck('user_id')
            ->toArray();

        if (empty($teacherIds)) {
            $teachers = collect();
        } else {
            $teachers = User::with(['role', 'detail', 'division'])
                ->whereHas('role', function ($q) {
                    $q->where('id', '>=', 4); // 講師
                })
                ->whereIn('id', $teacherIds)
                ->orderBy('name', 'asc')
                ->paginate(10); // ページネーション
        }

        return view('user.teacher.teachers_list', compact('teachers'));
    }

    /**
     * 先生詳細画面
     */
    public function show($teacherId)
    {
        $teacher = User::with(['role', 'detail', 'division'])
            ->whereHas('role', function ($q) {
                $q->where('id', '>=', 4);
            })
            ->whereIn('id', function ($query) {
                $query->select('user_id')->from('course_teachers');
            })
            ->findOrFail($teacherId);

        return view('user.teacher.teachers_info', compact('teacher'));
    }
}