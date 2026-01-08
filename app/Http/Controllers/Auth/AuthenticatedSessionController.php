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
        $courses = Course::loginVisible()
            ->orderBy('start_date', 'desc')
            ->get();

        $selected_course = $request->query('course_id');

        return view('auth.login', compact('courses', 'selected_course'));
    }

    /**
     * ログイン処理
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'email'     => 'required|string|email',
            'password'  => 'required|string',
            'course_id' => 'required|integer',
        ]);

        // ユーザー取得
        $user = User::where('email', $request->email)->first();

        // 認証チェック
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'メールアドレスかパスワードが正しくありません。',
            ])->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | ユーザー詳細ステータスチェック（停止・無効）
        |--------------------------------------------------------------------------
        */
        if ($user->detail && in_array($user->detail->status, [0, 2], true)) {

            $statusLabel = match ($user->detail->status) {
                0 => '無効',
                2 => '停止',
                default => '制限',
            };

            $message = "このアカウントは現在「{$statusLabel}」されています。";


            return back()
                ->withErrors([
                    'email' => $message,
                ])
                ->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | ロール制限（ログイン不可ユーザー）
        |--------------------------------------------------------------------------
        */
        if ($user->role_id == 1) {
            return back()->withErrors([
                'email' => 'このユーザーはログインできません。',
            ])->onlyInput('email');
        }

        // 講座チェック
        $course = Course::find($request->course_id);
        if (!$course) {
            return back()->withErrors([
                'course_id' => '講座が存在しません。',
            ])->onlyInput('course_id');
        }

        // 一般ユーザー（guest / 生徒 / アルバイト）
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

        /*
        |--------------------------------------------------------------------------
        | ログイン
        |--------------------------------------------------------------------------
        */
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();

        // 講座IDをセッションに保存
        session(['course_id' => $course->id]);

        // ユーザー設定（テーマ・文字サイズ）
        $user_details = $user->detail;
        session([
            'settings' => [
                'theme_id' => $user_details?->theme_id ?? 1,
                'fontsize' => $user_details?->fontsize ?? 1,
            ],
        ]);

        // ロール別リダイレクト
        return match ($user->role_id) {
            2, 3, 4 => redirect()->route('user.top'),           // guest / 生徒 / アルバイト
            5, 6, 7, 8 => redirect()->route('admin.dashboard'), // 管理系
            default => redirect()->route('user.top'),
        };
    }

    /**
     * ログアウト
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
