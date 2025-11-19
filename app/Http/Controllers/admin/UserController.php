<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ユーザー一覧
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == 2) { // 担当講師
            $users = User::with('detail')
                ->where('courses_id', $user->courses_id)
                ->get();
        } else {
            $users = User::with('detail')->get();
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * ユーザー作成画面
     */
    public function create()
    {
        $roles = Role::all();
        $courses = Course::all();

        return view('admin.users.create', compact('roles', 'courses'));
    }

    /**
     * ユーザー登録
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:50',
            'furigana' => 'required|string|max:50',
            'roman_name' => 'required|string|max:50',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'courses_id' => 'nullable|exists:courses,id',
            'email' => 'nullable|email|unique:users,email',
        ]);

        // パスワードをハッシュ化
        $validated['password'] = Hash::make($validated['password']);

        // 作成者IDを追加
        $validated['created_user_id'] = auth()->user()->id;

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'ユーザー作成完了');
    }

    /**
     * ユーザー編集画面
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $courses = Course::all();

        return view('admin.users.edit', compact('user', 'roles', 'courses'));
    }

    /**
     * ユーザー更新
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:50',
            'furigana' => 'nullable|string|max:50',
            'roman_name' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'courses_id' => 'nullable|exists:courses,id',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['updated_user_id'] = auth()->user()->id;

        $user->update($validated);

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', '基本情報を更新しました。');
    }


    /**
     * ユーザー削除
     */
    public function destroy(User $user)
    {
        $user->deleted_user_id = auth()->user()->id;
        $user->save();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'ユーザー削除完了');
    }

    public function show($id)
    {
        $user = User::with('detail')->findOrFail($id); // ユーザー詳細も取得
        return view('admin.users.show', compact('user'));
    }
}
