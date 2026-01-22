<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class MyCourseController extends Controller
{
    /**
     * 講座情報表示
     */
    public function index()
    {
        // 表示用講座ID取得（なりすまし優先）
        $courseId = $this->getDisplayCourseId();

        if (!$courseId) {
            abort(404, '講座が見つかりません');
        }

        // 講座取得
        $course = Course::find($courseId);

        if (!$course) {
            abort(404, '講座が見つかりません');
        }

        return view('user.course.courses_info', compact('course'));
    }

    /**
     * 表示用講座ID取得
     * 優先順位：
     * 1. なりすまし講座
     * 2. 本講座
     */
    private function getDisplayCourseId(): ?int
    {
        if (session()->has('impersonator_course_id')) {
            return session('impersonator_course_id');
        }

        return session('course_id');
    }
}
