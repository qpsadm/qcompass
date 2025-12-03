<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * role_id をチェックするミドルウェア
     * 例: ->middleware('role:4,5,6,7,8')
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'ログインが必要です。');
        }

        $roleId = $user->role_id ?? null;

        if (!$roleId) {
            abort(403, 'アクセス権限がありません。');
        }

        if ($roleId == 1) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'このアカウントではログインできません。',
            ]);
        }

        if (in_array($roleId, [2, 3]) && $request->is('admin/*')) {
            return redirect()->route('user.top')->with('error', 'この権限では管理画面にアクセスできません。');
        }

        // allowedRoles が文字列の場合に対応
        $roles = [];
        foreach ($allowedRoles as $r) {
            $roles = array_merge($roles, explode(',', $r));
        }
        $roles = array_map('intval', $roles);

        if (!empty($roles) && !in_array($roleId, $roles)) {
            abort(403, 'アクセス権限がありません。');
        }

        return $next($request);
    }
}
