<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * role_id をチェックするミドルウェア
     * 例: ->middleware('role:2,3') なら role_id 2 または 3 だけアクセス可
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles)
    {
        // 未ログインなら 403
        if (!Auth::check()) {
            abort(403, 'ログインが必要です。');
        }

        $roleId = Auth::user()->role_id;

        // role_id=1 はログイン不可 → その場でログアウトさせる
        if ($roleId == 1) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'このアカウントではログインできません。',
            ]);
        }

        // アクセス許可されていない role_id
        if (!in_array($roleId, $allowedRoles)) {
            abort(403, 'アクセス権限がありません。');
        }

        return $next($request);
    }
}
