<?php

namespace App\Http\Controllers\Auth;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'email'     => 'required|string|email',
            'password'  => 'required|string',
            'course_id' => 'required|integer',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'メールアドレスかパスワードが正しくありません。',
            ])->onlyInput('email');
        }

        if ($user->role_id == 1) { // ログイン不可ユーザー
            return back()->withErrors([
                'email' => 'このユーザーはログインできません。',
            ])->onlyInput('email');
        }

        $course = Course::find($request->course_id);
        if (!$course) {
            return back()->withErrors([
                'course_id' => '講座が存在しません。',
            ])->onlyInput('course_id');
        }

        // 一般ユーザー（guest,生徒,アルバイト）は講座チェックと isLoginable() を適用
        if ($user->role_id < 5) {
            if (!$user->courses->contains('id', $course->id)) {
                return back()->withErrors([
                    'course_id' => 'このユーザーは選択されたコースに所属していません。',
                ])->onlyInput('course_id');
            }

            if (!$course->isLoginable()) {
                return back()->withErrors([
                    'course_id' => 'この講座は現在ログインできません。',
                ]);
            }
        }

        // ログイン
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();

        // 講座IDをセッションに保存
        session(['course_id' => $course->id]);

        // ユーザーのテーマ・フォントサイズをセッションに保存
        $user_details = $user->detail;
        session([
            'settings' => [
                'theme_id' => $user_details?->theme_id ?? 1,
                'fontsize' => $user_details?->fontsize ?? 1,
            ]
        ]);

        // ロール別リダイレクト
        return match ($user->role_id) {
            2, 3, 4 => redirect()->route('user.top'),          // guest / 生徒 / アルバイト
            5, 6, 7, 8 => redirect()->route('admin.dashboard'), // パート / 講師 / 事務 / システム管理者
            default => redirect()->route('user.top'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // なりすまし解除
        if (session()->has('impersonator_id')) {
            $adminId = session('impersonator_id');
            Auth::loginUsingId($adminId);
            session()->forget('impersonator_id');

            return redirect()
                ->route('admin.dashboard')
                ->with('status', 'なりすましを解除しました');
        }

        // 通常ログアウト
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
