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
        $courses = Course::all(); // 全コース取得
        $selected_course = $request->query('course_id'); // URLパラメータ取得

        return view('auth.login', compact('courses', 'selected_course'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'login_name' => 'required|string',
            'password' => 'required|string',
            'course_id' => 'required|integer',
        ]);

        // 名前でユーザー検索
        $user = User::where('name', $request->login_name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login_name' => 'ユーザー名かパスワードが正しくありません。',
            ])->onlyInput('login_name');
        }

        // 選択されたコースが所属コースか判定
        // if (!$user->courses->contains('id', $request->course_id)) {
        //     return back()->withErrors([
        //         'course_id' => 'このユーザーは選択されたコースに所属していません。',
        //     ])->onlyInput('course_id');
        // }

        // 🔥 ログイン不可(role_id=1) をここで弾く（最重要）
        if ($user->role_id == 1) {
            return back()->withErrors([
                'login_name' => 'このユーザーはログインできません。',
            ]);
        }

        // ログイン成功
        Auth::login($user, $request->filled('remember'));

        return redirect()->intended('dashboard');
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
