<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $search = $request->input('search');

        // if ($search) {
        //     // Scout を使った全文検索
        //     $users = User::search($search)->paginate(10);
        // } else {
        //     $users = User::orderBy('id', 'desc')->paginate(10);
        // }
        $users = User::all(); // すべてのユーザーを取得
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable',
            'name' => 'nullable',
            'furigana' => 'nullable',
            'roman_name' => 'nullable',
            'password' => 'nullable',
            'role_id' => 'nullable',
            'courses_id' => 'nullable',
            'remember_token' => 'nullable',
            'email' => 'nullable',
            'email_verified_at' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        User::create($validated);
        return redirect()->route('admin.users.index')->with('success', 'User作成完了');
    }

    public function show($id)
    {
        $User = User::findOrFail($id);
        return view('admin.users.show', compact('User'));
    }

    public function edit($id)
    {
        $User = User::findOrFail($id);
        return view('admin.users.edit', compact('User'));
    }

    public function update(Request $request, $id)
    {
        $User = User::findOrFail($id);
        $validated = $request->validate([
            'code' => 'nullable',
            'name' => 'nullable',
            'furigana' => 'nullable',
            'roman_name' => 'nullable',
            'password' => 'nullable',
            'role_id' => 'nullable',
            'courses_id' => 'nullable',
            'remember_token' => 'nullable',
            'email' => 'nullable',
            'email_verified_at' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        $User->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'User更新完了');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User削除完了');
    }
}