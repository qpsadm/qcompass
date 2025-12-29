<?php

namespace App\Http\Controllers\Auth;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    public function create(Request $request)
    {
        $courses = Course::loginVisible()
            ->orderBy('start_date', 'desc')
            ->get();

        $selected_course = $request->query('course_id');

        return view('auth.login', compact('courses', 'selected_course'));
    }



    /**
     * Handle an incoming authentication request.
     */
    // ---------------- ログイン処理 ----------------
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'course_id'  => 'required|integer',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'メールアドレスかパスワードが正しくありません。',
            ])->onlyInput('email');
        }

        if ($user->role_id == 1) {
            return back()->withErrors([
                'email' => 'このユーザーはログインできません。',
            ])->onlyInput('email');
        }

        if ($user->role_id != 8 && !$user->courses->contains('id', $request->course_id)) {
            return back()->withErrors([
                'course_id' => 'このユーザーは選択されたコースに所属していません。',
            ])->onlyInput('course_id');
        }

        $course = Course::find($request->course_id);

        if (!$course) {
            return back()->withErrors([
                'course_id' => '講座が存在しません。',
            ]);
        }

        // 管理者以外は isLoginable() をチェック
        if ($user->role_id !== 8 && !$course->isLoginable()) {
            return back()->withErrors([
                'course_id' => 'この講座は現在ログインできません。',
            ]);
        }

        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();

        // ★ 講座IDをセッションに保存（これが無いと全部壊れる）
        session([
            'course_id' => $request->course_id,
        ]);

        // セッションにテーマ・フォントサイズ保存
        $user_details = $user->detail;
        session([
            'settings' => [
                'theme_id' => $user_details?->theme_id ?? 1,
                'fontsize' => $user_details?->fontsize ?? 1,
            ]
        ]);

        return match ($user->role_id) {
            3 => redirect()->route('user.top'),
            6, 8 => redirect()->route('admin.dashboard'),
            default => redirect()->route('user.top'),
        };
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // ★ なりすまし中なら「ログアウト＝解除」
        if (session()->has('impersonator_id')) {

            $adminId = session('impersonator_id');

            // 管理者に戻す
            Auth::loginUsingId($adminId);

            // なりすまし情報を削除
            session()->forget('impersonator_id');

            return redirect()
                ->route('admin.dashboard')
                ->with('status', 'なりすましを解除しました');
        }

        // ===== 通常ログアウト =====
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
