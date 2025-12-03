<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCourseTeacherCrud
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'ログインしてください。');
        }

        // CRUD権限なしユーザー
        if (in_array($user->role_id, [1, 2, 3, 4])) {
            abort(403, 'アクセス権限がありません。');
        }

        // role 5 は制限付き
        if ($user->role_id == 5) {
            // course_teacher, reports, questions, agenda は OK
            $allowed = ['course_teacher', 'reports', 'questions', 'agenda'];
            $path = $request->path();
            $isAllowed = false;
            foreach ($allowed as $a) {
                if (str_contains($path, $a)) {
                    $isAllowed = true;
                    break;
                }
            }
            if (!$isAllowed) {
                abort(403, 'アクセス権限がありません。');
            }
        }

        return $next($request);
    }
}
