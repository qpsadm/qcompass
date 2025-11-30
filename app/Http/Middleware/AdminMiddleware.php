<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * 管理者でなければユーザーダッシュボードへリダイレクトする。
     * JSON リクエスト（API/Ajax）の場合は 403 を返す。
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 管理者(8)と講師(6)を許可
        if (!in_array(Auth::user()->role_id, [6, 8])) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }
            return redirect()->route('user.top');
        }

        return $next($request);
    }
}
