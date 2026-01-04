<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminStrictMiddleware
{
    public function handle($request, Closure $next)
    {
        // システム管理者・事務のみ
        if (!in_array(Auth::user()->role_id, [7, 8])) {
            abort(403, 'この操作は許可されていません。');
        }

        return $next($request);
    }
}
