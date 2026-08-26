<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 管理画面に入れる人（アルバイト以上）
        if (!in_array(Auth::user()->role_id, [4, 5, 6, 7, 8])) {
            return redirect()->route('user.top')
                ->with('error', '管理画面にアクセスできません。');
        }

        return $next($request);
    }
}