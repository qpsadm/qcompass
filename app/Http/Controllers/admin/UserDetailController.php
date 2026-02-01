<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Role;
use App\Models\Theme;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class UserDetailController extends Controller
{
    /**
     * 新規作成
     */
    public function create(User $user)
    {
        // 既に詳細があれば編集画面へ
        if ($user->detail) {
            return redirect()->route('admin.user_details.edit', [
                'user' => $user->id,
                'detail' => $user->detail->id,
            ]);
        }

        $themes = Theme::all();

        return view('admin.user_details.create', compact('user', 'themes'));
    }

    /**
     * 保存
     */
    public function store(Request $request, User $user)
    {
        $data = $request->validate([
            // アバター関連
            'avatar_type' => 'nullable|in:1,2,3',
            'avatar_path' => 'nullable|file|image|max:2048',

            // 基本情報
            'birthday' => 'nullable|date',
            'gender' => 'nullable|integer',
            'phone1' => 'nullable|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:10',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:50',

            // UI/状態
            'theme_id' => 'nullable|integer',
            'status' => 'nullable|integer',

            // その他
            'bio' => 'nullable|string',
            'note' => 'nullable|string',
            'memo' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'leaving_reason' => 'nullable|string',
        ]);

        // アバター画像アップロード（管理画面用）
        if ($request->hasFile('avatar_path')) {
            $data['avatar_path'] = $request->file('avatar_path')->store('avatars', 'public');
        }

        // デフォルト値補完
        $data['avatar_type'] = $data['avatar_type'] ?? 1;
        $data['status'] = $data['status'] ?? 1;
        $data['user_id'] = $user->id;

        UserDetail::create($data);

        return redirect()
            ->route('admin.users.show', ['user' => $user->id, 'tab' => 'detail'])
            ->with('success', '詳細情報を保存しました。');
    }

    /**
     * 編集
     */
    public function edit(User $user, UserDetail $detail)
    {
        $roles = Role::all();
        $courses = Course::all();
        $themes = Theme::all();

        return view('admin.user_details.edit', compact(
            'user',
            'detail',
            'roles',
            'courses',
            'themes'
        ));
    }

    /**
     * 更新
     */
    public function update(Request $request, User $user, UserDetail $detail)
    {
        $data = $request->validate([
            // アバター関連
            'avatar_type' => 'nullable|in:1,2,3,4,5,6',
            'avatar_path' => 'nullable|file|image|max:2048',

            // 基本情報
            'birthday' => 'nullable|date',
            'gender' => 'nullable|integer',
            'phone1' => 'nullable|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:10',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:50',

            // UI/状態
            'theme_id' => 'nullable|integer',
            'status' => 'nullable|integer',

            // その他
            'bio' => 'nullable|string',
            'note' => 'nullable|string',
            'memo' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'leaving_reason' => 'nullable|string',
        ]);

        // 新しいアバター画像があれば差し替え
        if ($request->hasFile('avatar_path')) {
            if ($detail->avatar_path) {
                Storage::disk('public')->delete($detail->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar_path')->store('avatars', 'public');
        }

        // デフォルト補完
        $data['avatar_type'] = $data['avatar_type'] ?? $detail->avatar_type ?? 1;
        $data['status'] = $data['status'] ?? $detail->status ?? 1;

        $detail->update($data);

        return redirect()
            ->route('admin.users.show', ['user' => $user->id, 'tab' => 'detail'])
            ->with('success', '詳細情報を更新しました。');
    }

    /**
     * 削除
     */
    public function destroy(User $user, UserDetail $detail)
    {
        if ($detail->avatar_path) {
            Storage::disk('public')->delete($detail->avatar_path);
        }

        $detail->delete();

        return redirect()
            ->route('admin.users.show', ['user' => $user->id])
            ->with('success', '詳細情報を削除しました。');
    }

    /**
     * 表示
     */
    public function show(User $user)
    {
        $user->load('detail');

        return view('admin.users.show', compact('user'));
    }
}
