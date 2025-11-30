<?php
// app/Http/Middleware/RedirectNonUserDashboard.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectNonUserDashboard
{
    public function handle(Request $request, Closure $next)
    {
        // 管理者専用ページにユーザーがアクセスした場合
        if (Auth::check() && $request->is('admin/*') && !in_array(Auth::user()->role_id, [6, 8])) {
            return redirect()->route('user.top');
        }

        return $next($request);
    }
}
