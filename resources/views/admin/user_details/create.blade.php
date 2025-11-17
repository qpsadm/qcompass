@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ユーザー詳細作成</h1>
        <form action="{{ route('admin.user_details.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-medium mb-1">ユーザーID</label>
                <input type="text" name="user_id" value="{{ old('user_id', $UserDetail->user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">生年月日</label>
                <input type="date" name="birthday" value="{{ old('birthday', $UserDetail->birthday ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">性別</label>
                <select name="gender" class="border px-2 py-1 w-full rounded">
                    <option value="">選択してください</option>
                    <option value="0" {{ old('gender', $UserDetail->gender ?? '') == 0 ? 'selected' : '' }}>男性
                    </option>
                    <option value="1" {{ old('gender', $UserDetail->gender ?? '') == 1 ? 'selected' : '' }}>女性
                    </option>
                    <option value="2" {{ old('gender', $UserDetail->gender ?? '') == 2 ? 'selected' : '' }}>その他
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">電話番号1</label>
                <input type="text" name="phone1" value="{{ old('phone1', $UserDetail->phone1 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">電話番号2</label>
                <input type="text" name="phone2" value="{{ old('phone2', $UserDetail->phone2 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">郵便番号</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $UserDetail->postal_code ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">住所1</label>
                <input type="text" name="address1" value="{{ old('address1', $UserDetail->address1 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">住所2</label>
                <input type="text" name="address2" value="{{ old('address2', $UserDetail->address2 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">緊急連絡先</label>
                <input type="text" name="emergency_contact"
                    value="{{ old('emergency_contact', $UserDetail->emergency_contact ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">写真パス</label>
                <input type="text" name="avatar_path" value="{{ old('avatar_path', $UserDetail->avatar_path ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">テーマカラー</label>
                <select name="theme_color" class="border px-2 py-1 w-full rounded">
                    <option value="">選択してください</option>
                    <option value="0" {{ old('theme_color', $UserDetail->theme_color ?? '') == 0 ? 'selected' : '' }}>
                        赤
                    </option>
                    <option value="1" {{ old('theme_color', $UserDetail->theme_color ?? '') == 1 ? 'selected' : '' }}>
                        青</option>
                    <option value="2" {{ old('theme_color', $UserDetail->theme_color ?? '') == 2 ? 'selected' : '' }}>
                        緑</option>
                    <option value="3" {{ old('theme_color', $UserDetail->theme_color ?? '') == 3 ? 'selected' : '' }}>
                        黄</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">ステータス</label>
                <select name="status" class="border px-2 py-1 w-full rounded">
                    <option value="">選択してください</option>
                    <option value="0" {{ old('status', $UserDetail->status ?? '') == 0 ? 'selected' : '' }}>非アクティブ
                    </option>
                    <option value="1" {{ old('status', $UserDetail->status ?? '') == 1 ? 'selected' : '' }}>アクティブ
                    </option>
                    <option value="2" {{ old('status', $UserDetail->status ?? '') == 2 ? 'selected' : '' }}>停止
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">表示/非表示</label>
                <input type="text" name="is_show" value="{{ old('is_show', $UserDetail->is_show ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">divisions_id</label>
                <input type="text" name="divisions_id"
                    value="{{ old('divisions_id', $UserDetail->divisions_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">自己紹介</label>
                <input type="text" name="bio" value="{{ old('bio', $UserDetail->bio ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">メモ</label>
                <input type="text" name="memo1" value="{{ old('memo1', $UserDetail->memo1 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">備考</label>
                <input type="text" name="memo2" value="{{ old('memo2', $UserDetail->memo2 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">入校日/入社日</label>
                <input type="date" name="joining_date"
                    value="{{ old('joining_date', $UserDetail->joining_date ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">退校日/退職日</label>
                <input type="date" name="leaving_date"
                    value="{{ old('leaving_date', $UserDetail->leaving_date ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">退校/退職理由</label>
                <input type="text" name="leaving_reason"
                    value="{{ old('leaving_reason', $UserDetail->leaving_reason ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">作成者名</label>
                <input type="text" name="created_user_id"
                    value="{{ old('created_user_id', $UserDetail->created_user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">更新者名</label>
                <input type="text" name="updated_user_id"
                    value="{{ old('updated_user_id', $UserDetail->updated_user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">削除日</label>
                <input type="text" name="deleted_at" value="{{ old('deleted_at', $UserDetail->deleted_at ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">削除者</label>
                <input type="text" name="deleted_user_id"
                    value="{{ old('deleted_user_id', $UserDetail->deleted_user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
        </form>
    </div>
@endsection
