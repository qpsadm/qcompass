<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Role;
use App\Models\Theme;
use App\Models\Course;
use App\Models\Division;

class UserDetailController extends Controller
{
    public function create(User $user)
    {
        // 既に詳細があれば編集画面にリダイレクト
        if ($user->detail) {
            return redirect()->route('admin.user_details.edit', [
                'user' => $user->id,
                'detail' => $user->detail->id
            ]);
        }

        // 表示可能な部署を取得
        $divisions = Division::where('is_show', true)->get();

        return view('admin.user_details.create', compact('user', 'divisions'));
    }

    public function store(Request $request, User $user)
    {
        $data = $request->validate([
            'birthday' => 'nullable|date',
            'gender' => 'nullable|integer',
            'phone1' => 'nullable|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:10',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:50',
            'avatar_path' => 'nullable|file|image|max:2048',
            'theme_id' => 'nullable|string|max:20',
            'status' => 'nullable|integer',
            'bio' => 'nullable|string',
            'note' => 'nullable|string',
            'memo' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'leaving_reason' => 'nullable|string',
        ]);

        if ($request->hasFile('avatar_path')) {
            $data['avatar_path'] = $request->file('avatar_path')->store('avatars', 'public');
        }

        $data['status'] = $data['status'] ?? 1;

        // 既存レコードがあれば update、なければ create
        if ($user->detail) {
            $user->detail->update($data);
        } else {
            $data['user_id'] = $user->id;
            UserDetail::create($data);
        }

        return redirect()
            ->route('admin.users.show', ['user' => $user->id, 'tab' => 'detail'])
            ->with('success', '詳細情報を保存しました。');
    }



    public function edit(User $user, UserDetail $detail)
    {
        $roles = Role::all();      // 権限用
        $courses = Course::all();  // 講座用
        $themes = Theme::all();    // テーマカラー用
        $divisions = Division::where('is_show', true)->get(); // 部署追加

        return view('admin.user_details.edit', compact('user', 'detail', 'roles', 'courses', 'themes', 'divisions'));
    }

    public function update(Request $request, User $user, UserDetail $detail)
    {
        $data = $request->validate([
            'birthday' => 'nullable|date',
            'gender' => 'nullable|integer',
            'phone1' => 'nullable|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:10',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:50',
            'avatar_path' => 'nullable|image|max:2048',
            'theme_id' => 'nullable|string|max:20',
            'status' => 'nullable|integer',
            'bio' => 'nullable|string',
            'note' => 'nullable|string',
            'memo' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'leaving_reason' => 'nullable|string',
        ]);

        if ($request->hasFile('avatar_path')) {
            $data['avatar_path'] = $request->file('avatar_path')->store('avatars', 'public');
        }

        // 必須値の補完
        $data['status'] = $data['status'] ?? $detail->status ?? 1;

        $detail->update($data);

        return redirect()->route('admin.users.show', ['user' => $user->id, 'tab' => 'detail'])
            ->with('success', '詳細情報を更新しました。');
    }

    public function destroy(User $user, UserDetail $detail)
    {
        $detail->delete();

        return redirect()->route('admin.users.show', ['user' => $user->id])
            ->with('success', '詳細情報を削除しました。');
    }

    public function show(User $user)
    {
        // detail を eager load
        $user->load('detail');

        return view('admin.users.show', compact('user'));
    }
}
