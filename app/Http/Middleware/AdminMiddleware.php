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
        // 未認証ならログインページへ
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 管理者判定（role_id == 8 を管理者と想定）
        // 必要なら here を your own logic に置き換える
        if (Auth::user()->role_id != 8) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }

            return redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}