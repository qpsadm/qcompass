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
    /**
     * Display the login view.
     */
    public function create(Request $request)
    {
        // 終了日が未設定または未来の講座だけ取得
        $courses = Course::where(function ($q) {
            $q->whereNull('end_date')           // 終了日未設定の講座は含める
                ->orWhere('end_date', '>=', now()); // 終了日が未来の講座のみ
        })->get();

        $selected_course = $request->query('course_id'); // URLパラメータ取得

        return view('auth.login', compact('courses', 'selected_course'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'course_id'  => 'required|integer',
        ]);

        // ⭐ メールアドレスでユーザー検索
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'メールアドレスかパスワードが正しくありません。',
            ])->onlyInput('email');
        }

        // 🔥 role_id=1（ログイン不可ユーザー）を弾く
        if ($user->role_id == 1) {
            return back()->withErrors([
                'email' => 'このユーザーはログインできません。',
            ])->onlyInput('email');
        }

        // コース所属チェック（管理者 role_id=8 はスキップ）
        if ($user->role_id != 8 && !$user->courses->contains('id', $request->course_id)) {
            return back()->withErrors([
                'course_id' => 'このユーザーは選択されたコースに所属していません。',
            ])->onlyInput('course_id');
        }

        // ログイン成功
        Auth::login($user, $request->filled('remember'));

        // ロール別リダイレクト
        switch ($user->role_id) {
            case 3: // 生徒
                return redirect()->route('user.top');

            case 6: // 講師
            case 8: // 管理者
                return redirect()->route('admin.dashboard');

            default:
                return redirect()->route('user.top');
        }
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
