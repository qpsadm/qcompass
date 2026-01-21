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
    /**
     * ログイン画面表示
     */
    public function create(Request $request)
    {
        // 管理側ONの講座をすべて表示
        $courses = Course::where('is_show', 1)
            ->orderBy('course_name', 'asc')
            ->get();

        $showCourse = $courses->isNotEmpty();
        $selected_course = $request->query('course_id');

        return view('auth.login', compact(
            'courses',
            'selected_course',
            'showCourse'
        ));
    }


    /**
     * ログイン処理
     */
    public function store(Request $request)
    {
        $showCourse = Course::where('is_show', 1)->exists();

        $rules = [
            'email'    => 'required|email',
            'password' => 'required|string',
        ];

        if ($showCourse) {
            $rules['course_id'] = 'required|integer';
        }

        $request->validate($rules);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'メールアドレスかパスワードが正しくありません。',
            ])->onlyInput('email');
        }

        // ユーザー状態
        if ($user->detail && in_array($user->detail->status, [0, 2], true)) {
            return back()->withErrors([
                'email' => 'このアカウントは現在利用できません。',
            ]);
        }

        if ($user->role_id === 1) {
            return back()->withErrors([
                'email' => 'このユーザーはログインできません。',
            ]);
        }

        $course = null;

        if ($showCourse) {
            $course = Course::where('is_show', 1)
                ->where('id', $request->course_id)
                ->first();

            if (!$course) {
                return back()->withErrors([
                    'course_id' => '講座が存在しません。',
                ]);
            }

            if ($user->role_id < 5) {
                if (!$user->courses->contains('id', $course->id)) {
                    return back()->withErrors([
                        'course_id' => 'この講座に所属していません。',
                    ]);
                }

                if (!$course->isLoginable()) {
                    return back()->withErrors([
                        'course_id' => 'この講座は現在ログインできません。',
                    ]);
                }
            }
        }


        Auth::login($user);
        $request->session()->regenerate();

        if ($course) {
            session(['course_id' => $course->id]);
        }

        session([
            'settings' => [
                'theme_id'  => $user->detail?->theme_id ?? 1,
                'fontsize' => $user->detail?->fontsize ?? 1,
            ],
        ]);

        return match ($user->role_id) {
            2, 3, 4 => redirect()->route('user.top'),
            5, 6, 7, 8 => redirect()->route('admin.dashboard'),
            default => redirect()->route('user.top'),
        };
    }


    /**
     * ログアウト
     */
    public function destroy(Request $request)
    {
        // なりすまし中の場合は管理者に戻す
        if (session()->has('impersonator_id')) {
            $adminId = session('impersonator_id');
            Auth::loginUsingId($adminId);

            // 元の講座IDを復元
            $originalCourseId = session('impersonator_course_id');
            if ($originalCourseId) {
                session(['course_id' => $originalCourseId]);
            } else {
                session()->forget('course_id');
            }

            // なりすまし情報を削除
            session()->forget(['impersonator_id', 'impersonator_course_id']);

            return redirect()
                ->route('admin.dashboard')
                ->with('status', 'なりすましを解除しました');
        }

        // 通常ログアウト処理
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }


    /**
     * 表示可能な講座が存在するか
     */
    private function hasVisibleCourse(): bool
    {
        return Course::loginVisible()->exists();
    }
}
