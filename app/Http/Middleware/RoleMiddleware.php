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

        // 未ログイン
        if (!$user) {
            return redirect()->route('login');
        }

        $roleId = $user->role_id;

        // ログイン不可
        if ($roleId == 1) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'このアカウントではログインできません。'
            ]);
        }

        // 管理画面不可（role 2,3）
        if (in_array($roleId, [2, 3]) && $request->is('admin/*')) {
            return redirect()->route('user.top')->with('error', '管理画面にアクセスできません。');
        }

        // allowedRoles が設定されていればアクセスチェック
        if (!empty($allowedRoles)) {
            $roles = [];
            foreach ($allowedRoles as $r) {
                $roles = array_merge($roles, explode(',', $r));
            }
            $roles = array_map('intval', $roles);

            if (!in_array($roleId, $roles)) {
                abort(403, 'アクセス権限がありません。');
            }
        }

        // role 5 の制限付きアクセス
        if ($roleId == 5) {
            $restricted = [
                'roles',
                'users',
                'levels',
                'organizers',
                'announcements',
                'achievements_release'
            ];
            foreach ($restricted as $r) {
                if ($request->is("admin/$r*")) {
                    abort(403, 'アクセス権限がありません。');
                }
            }
        }

        return $next($request);
    }
}
