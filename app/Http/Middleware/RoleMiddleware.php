<?php

public function handle(Request $request, Closure $next, ...$allowedRoles)
{
    $user = Auth::user();
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

    // 管理画面不可
    if (in_array($roleId, [2, 3]) && $request->is('admin/*')) {
        return redirect()->route('user.top')->with('error', '管理画面にアクセスできません。');
    }

    // 5 は制限付きアクセス
    if ($roleId == 5) {
        $restricted = ['roles', 'users', 'levels', 'organizers', 'announcements', 'achievements_release'];
        foreach ($restricted as $r) {
            if ($request->is("admin/$r*")) {
                abort(403, 'アクセス権限がありません。');
            }
        }
    }

    // allowedRoles があればチェック
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
