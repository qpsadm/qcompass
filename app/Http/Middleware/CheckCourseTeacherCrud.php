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

        // 1. アルバイト社員（role 4）のアクセス制限
        if ($roleId === 4) {
            $partTimerAllowed = [
                '*files*',       // ファイル操作
                '*questions*',   // 質問
                '*agenda*',      // アジェンダ
                '*impersonate*', // なりすまし
            ];

            if (!$request->routeIs($partTimerAllowed)) {
                abort(403, 'アルバイトアカウントではこの機能にアクセスできません。');
            }
        }

        // 2. パート社員（role 5）のアクセス制限
        if ($roleId === 5) {
            $contractUserAllowed = [
                '*files*',         // ファイル操作
                '*reports*',       // レポート
                '*questions*',     // 質問
                '*agenda*',        // アジェンダ
                '*announcements*', // お知らせ
                '*impersonate*',   // なりすまし
            ];

            if (!$request->routeIs($contractUserAllowed)) {
                abort(403, 'パート社員アカウントではこの機能にアクセスできません。');
            }
        }

        return $next($request);
    }
}
