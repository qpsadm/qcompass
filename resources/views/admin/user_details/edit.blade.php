@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4" x-data="{ tab: 'basic' }">
    <h1 class="text-2xl font-bold mb-6">ユーザー編集</h1>

    <!-- タブボタン -->
    <div class="flex border-b mb-6">
        <button @click="tab = 'basic'" :class="tab === 'basic' ? 'border-b-2 border-blue-500 text-blue-500' : ''"
            class="px-4 py-2 font-semibold">基本情報</button>
        <button @click="tab = 'detail'" :class="tab === 'detail' ? 'border-b-2 border-blue-500 text-blue-500' : ''"
            class="px-4 py-2 font-semibold">詳細情報</button>
    </div>

    <!-- 基本情報フォーム -->
    <div x-show="tab === 'basic'">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-md space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold mb-1">ユーザーコード</label>
                <input type="text" name="code" value="{{ old('code', $user->code) }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">名前</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">フリガナ</label>
                <input type="text" name="furigana" value="{{ old('furigana', $user->furigana) }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">ローマ字</label>
                <input type="text" name="roman_name" value="{{ old('roman_name', $user->roman_name) }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">メール</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <!-- 権限セレクト -->
            <div>

                <label class="block font-semibold mb-1">権限</label>
                <select name="role_id" class="border px-3 py-2 rounded w-full">
                    <option value="">未選択</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>
                        {{ $role->role_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- 講座セレクト -->
            <div>
                <label class="block font-semibold mb-1">講座</label>
                <select name="courses_id" class="border px-3 py-2 rounded w-full">
                    <option value="">未選択</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" @selected(old('courses_id', $user->courses_id) == $course->id)>
                        {{ $course->course_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">パスワード（変更する場合のみ）</label>
                <input type="password" name="password" class="border px-3 py-2 rounded w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">
                基本情報更新
            </button>
        </form>
    </div>

    <!-- 詳細情報フォーム -->
    <div x-show="tab === 'detail'" x-cloak>
        @php
        $d = $user->detail;
        @endphp

        <form
            action="{{ $d
                    ? route('admin.user_details.update', ['user' => $user->id, 'detail' => $d->id])
                    : route('admin.user_details.store', ['user' => $user->id]) }}"
            method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md space-y-4">
            @csrf
            @if ($d)
            @method('PUT')
            @endif

            <div>
                <label class="block font-semibold mb-1">生年月日</label>
                <input type="date" name="birthday" value="{{ old('birthday', $d->birthday ?? '') }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">性別</label>
                <select name="gender" class="border px-3 py-2 rounded w-full">
                    <option value="">未選択</option>
                    <option value="1" @selected(old('gender', $d->gender ?? '') == 1)>男性</option>
                    <option value="2" @selected(old('gender', $d->gender ?? '') == 2)>女性</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">電話番号1</label>
                <input type="text" name="phone1" value="{{ old('phone1', $d->phone1 ?? '') }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">電話番号2</label>
                <input type="text" name="phone2" value="{{ old('phone2', $d->phone2 ?? '') }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">郵便番号</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $d->postal_code ?? '') }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">住所1</label>
                <input type="text" name="address1" value="{{ old('address1', $d->address1 ?? '') }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">住所2</label>
                <input type="text" name="address2" value="{{ old('address2', $d->address2 ?? '') }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">緊急連絡先</label>
                <input type="text" name="emergency_contact"
                    value="{{ old('emergency_contact', $d->emergency_contact ?? '') }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div class="mb-4">
                <label for="theme_id" class="block text-gray-700 font-medium mb-2">テーマカラー</label>
                <select name="theme_id" id="theme_id" class="w-full border rounded px-3 py-2">
                    <option value="">選択してください</option>
                    @foreach($themes as $theme)
                    <option value="{{ $theme->id }}"
                        {{ old('theme_id', $detail->theme_id) == $theme->id ? 'selected' : '' }}>
                        {{ $theme->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">自己紹介</label>
                <textarea name="bio" rows="4"
                    class="border px-3 py-2 rounded w-full">{{ old('bio', $d->bio ?? '') }}</textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1">メモ</label>
                <textarea name="note" rows="4"
                    class="border px-3 py-2 rounded w-full">{{ old('note', $d->note ?? '') }}</textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1">備考</label>
                <textarea name="memo" rows="4"
                    class="border px-3 py-2 rounded w-full">{{ old('memo', $d->memo ?? '') }}</textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1">入社日/入所日</label>
                <input type="date" name="joining_date" value="{{ old('joining_date', $d->joining_date ?? '') }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">退所日/退職日</label>
                <input type="date" name="leaving_date" value="{{ old('leaving_date', $d->leaving_date ?? '') }}"
                    class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">退校理由</label>
                <textarea name="leaving_reason" rows="4"
                    class="border px-3 py-2 rounded w-full">{{ old('leaving_reason', $d->leaving_reason ?? '') }}</textarea>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-2">
                詳細情報更新
            </button>
        </form>
    </div>
</div>
@endsection
