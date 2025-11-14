<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDetail;

class UserDetailController extends Controller
{
    public function index()
    {
        $user_details = UserDetail::all();
        return view('admin.user_details.index', compact('user_details'));
    }

    public function create()
    {
        return view('admin.user_details.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable',
            'birthday' => 'nullable',
            'gender' => 'nullable',
            'phone1' => 'nullable',
            'phone2' => 'nullable',
            'postal_code' => 'nullable',
            'address1' => 'nullable',
            'address2' => 'nullable',
            'emergency_contact' => 'nullable',
            'avatar_path' => 'nullable',
            'theme_color' => 'nullable',
            'status' => 'nullable',
            'is_show' => 'nullable',
            'divisions_id' => 'nullable',
            'bio' => 'nullable',
            'memo1' => 'nullable',
            'memo2' => 'nullable',
            'joining_date' => 'nullable',
            'leaving_date' => 'nullable',
            'leaving_reason' => 'nullable',
            'created_user_id' => 'nullable',
            'updated_user_id' => 'nullable',
            'deleted_at' => 'nullable',
            'deleted_user_id' => 'nullable',
        ]);
        UserDetail::create($validated);
        return redirect()->route('admin.user_details.index')->with('success', 'UserDetail作成完了');
    }

    public function show($id)
    {
        $UserDetail = UserDetail::findOrFail($id);
        return view('admin.user_details.show', compact('UserDetail'));
    }

    public function edit($id)
    {
        $UserDetail = UserDetail::findOrFail($id);
        return view('admin.user_details.edit', compact('UserDetail'));
    }

    public function update(Request $request, $id)
    {
        $UserDetail = UserDetail::findOrFail($id);

        $validated = $request->validate([
            'birthday' => 'nullable|date',
            'gender' => 'nullable|string',
            'phone1' => 'nullable|string',
            'phone2' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'address1' => 'nullable|string',
            'address2' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'avatar_path' => 'nullable|file|image|max:2048',
            'theme_color' => 'nullable|string',
            'status' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'divisions_id' => 'nullable|integer',
            'bio' => 'nullable|string',
            'memo1' => 'nullable|string',
            'memo2' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'leaving_reason' => 'nullable|string',
        ]);

        // ファイルアップロード処理
        if ($request->hasFile('avatar_path')) {
            $path = $request->file('avatar_path')->store('avatars', 'public');
            $validated['avatar_path'] = $path;
        }

        // 更新者IDをログインユーザーに設定
        $validated['updated_user_id'] = auth()->id();

        $UserDetail->update($validated);

        return redirect()->back()->with('success', '詳細情報を更新しました');
    }


    public function destroy($id)
    {
        UserDetail::findOrFail($id)->delete();
        return redirect()->route('admin.user_details.index')->with('success', 'UserDetail削除完了');
    }
}