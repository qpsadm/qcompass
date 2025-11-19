<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;

class UserDetailController extends Controller
{
    public function create(User $user)
    {
        return view('admin.user_details.create', compact('user'));
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
            'avatar_path' => 'nullable|image|max:2048',
            'theme_color' => 'nullable|string|max:20',
            'status' => 'nullable|integer',
            'is_show' => 'nullable|boolean',
            'divisions_id' => 'nullable|integer',
            'bio' => 'nullable|string',
            'memo1' => 'nullable|string',
            'memo2' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'leaving_reason' => 'nullable|string',
        ]);

        if ($request->hasFile('avatar_path')) {
            $data['avatar_path'] = $request->file('avatar_path')->store('avatars', 'public');
        }

        // 必須値のデフォルト設定
        $data['user_id'] = $user->id;
        $data['status'] = $data['status'] ?? 1;
        $data['is_show'] = $data['is_show'] ?? true;

        UserDetail::create($data);

        return redirect()->route('admin.users.show', ['user' => $user->id, 'tab' => 'detail'])
            ->with('success', '詳細情報を作成しました。');
    }

    public function edit(User $user)
    {
        $detail = $user->detail;
        return view('admin.user_details.edit', compact('user', 'detail'));
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
            'theme_color' => 'nullable|string|max:20',
            'status' => 'nullable|integer',
            'is_show' => 'nullable|boolean',
            'divisions_id' => 'nullable|integer',
            'bio' => 'nullable|string',
            'memo1' => 'nullable|string',
            'memo2' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'leaving_reason' => 'nullable|string',
        ]);

        if ($request->hasFile('avatar_path')) {
            $data['avatar_path'] = $request->file('avatar_path')->store('avatars', 'public');
        }

        // 必須値の補完
        $data['status'] = $data['status'] ?? $detail->status ?? 1;
        $data['is_show'] = $data['is_show'] ?? $detail->is_show ?? true;

        $detail->update($data);

        return redirect()->route('admin.users.show', ['user' => $user->id, 'tab' => 'detail'])
            ->with('success', '詳細情報を更新しました。');
    }

    public function destroy(User $user)
    {
        $user->detail?->delete();
        return redirect()->route('admin.users.show', ['user' => $user->id])
            ->with('success', '詳細情報を削除しました。');
    }
}
