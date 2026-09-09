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

        $roleId = (int) $user->role_id;

        // ログイン不可（role 1）
        if ($roleId === 1) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'このアカウントではログインできません。',
            ]);
        }

        // 管理画面不可（role 2, 3）
        if (in_array($roleId, [2, 3], true) && $request->is('admin/*')) {
            return redirect()->route('user.top')->with('error', '管理画面にアクセスできません。');
        }

        // allowedRoles が設定されていればアクセスチェック
        if (!empty($allowedRoles)) {
            $roles = [];
            foreach ($allowedRoles as $r) {
                $roles = array_merge($roles, explode(',', $r));
            }
            $roles = array_map('intval', $roles);

            if (!in_array($roleId, $roles, true)) {
                abort(403, 'アクセス権限がありません。');
            }
        }

        // アルバイト（role 4）とパート社員（role 5）に禁止する機能（URLパス）
        if (in_array($roleId, [4, 5], true)) {
            $restricted = [
                'roles',
                'users',
                'levels',
                'organizers',
                'courses',
                'achievements_release',
                'course_teacher',
                'course_users',
            ];

            foreach ($restricted as $r) {
                if ($request->is("admin/$r") || $request->is("admin/$r/*")) {

                    // users 配下であっても「なりすまし開始（impersonate）」は通過を許可
                    if ($r === 'users' && $request->is('admin/users/*/impersonate')) {
                        continue;
                    }

                    abort(403, 'アクセス権限がありません。');
                }
            }
        }

        return $next($request);
    }
}
