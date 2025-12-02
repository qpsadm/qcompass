<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyCourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ログインユーザーの講座を1件取得
        $course = $user->courses()->first();

        if (!$course) {
            abort(404, '講座が見つかりません');
        }

        // ビューに渡す
        return view('user.course.courses_info', compact('course'));
    }
}
