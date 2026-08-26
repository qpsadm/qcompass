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

        $roleId = (int) $user->role_id;

        // CRUD権限のないユーザー（受講生等）
        if (in_array($roleId, [1, 2, 3], true)) {
            abort(403, 'アクセス権限がありません。');
        }

        // // role 4（アルバイト社員）と role 5（パート社員）は特定のアクセスのみ許可
        // if (in_array($user->role_id, [4, 5])) {

        //     // 💡 admin. または 単体のプレフィックス配下の各機能をルート名・ワイルドカード指定で許可
        //     $isAllowed = $request->routeIs([
        //         '*course_teacher*',
        //         '*reports*',
        //         '*questions*',
        //         '*agenda*',
        //         '*announcements*', // 👈 admin.announcements.show や edit など全操作を許可
        //     ]) || $request->is('*announcements*'); // フォールバック用（URLパス判定）

        //     if (!$isAllowed) {
        //         abort(403, 'アクセス権限がありません。');
        //     }
        // }

        // ------------------------------------------
        // 1. アルバイト社員（role 4）のアクセス制限
        // ------------------------------------------
        if ($roleId === 4) {
            $partTimerAllowed = [
                // '*reports*',   // レポート
                '*questions*', // 質問
                '*agenda*',    // アジェンダ
                // ※ お知らせ（announcements）や講師機能（course_teacher）は除外
            ];

            if (!$request->routeIs($partTimerAllowed)) {
                abort(403, 'アルバイトアカウントではこの機能にアクセスできません。');
            }
        }

        // ------------------------------------------
        // 2. パート社員（role 5）のアクセス制限
        // ------------------------------------------
        if ($roleId === 5) {
            $contractUserAllowed = [
                // '*course_teacher*', // 講師機能
                '*reports*',        // レポート
                '*questions*',      // 質問
                '*agenda*',         // アジェンダ
                // '*announcements*',  // お知らせ
            ];

            if (!$request->routeIs($contractUserAllowed)) {
                abort(403, 'パート社員アカウントではこの機能にアクセスできません。');
            }
        }

        return $next($request);
    }
}