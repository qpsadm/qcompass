@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <h1 class="text-2xl font-bold mb-4">ユーザー詳細情報入力</h1>

    <form action="{{ route('admin.user_details.store', $user->id) }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf

        {{-- 生年月日 --}}
        <div>
            <label class="block font-semibold mb-1">生年月日</label>
            <input type="date" name="birthday"
                value="{{ old('birthday') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- 性別 --}}
        <div>
            <label class="block font-semibold mb-1">性別</label>
            <select name="gender" class="w-full border rounded px-3 py-2">
                <option value="">選択してください</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="9">その他</option>
            </select>
        </div>

        {{-- 電話番号 --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">電話番号1</label>
                <input type="text" name="phone1" value="{{ old('phone1') }}"
                    class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block font-semibold mb-1">電話番号2</label>
                <input type="text" name="phone2" value="{{ old('phone2') }}"
                    class="w-full border rounded px-3 py-2">
            </div>
        </div>

        {{-- 郵便番号 --}}
        <div>
            <label class="block font-semibold mb-1">郵便番号</label>
            <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- 住所 --}}
        <div>
            <label class="block font-semibold mb-1">住所1</label>
            <input type="text" name="address1" value="{{ old('address1') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-semibold mb-1">住所2</label>
            <input type="text" name="address2" value="{{ old('address2') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- 緊急連絡先 --}}
        <div>
            <label class="block font-semibold mb-1">緊急連絡先</label>
            <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- テーマID --}}
        <div>
            <label class="block font-semibold mb-1">テーマID</label>
            <input type="text" name="theme_id" value="{{ old('theme_id') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- ユーザー状態 --}}
        <div>
            <label class="block font-semibold mb-1">ユーザー状態</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="">選択してください</option>
                <option value="0">無効</option>
                <option value="1">有効</option>
            </select>
        </div>

        {{-- 自己紹介 --}}
        <div>
            <label class="block font-semibold mb-1">自己紹介</label>
            <textarea name="bio" rows="3" class="w-full border rounded px-3 py-2">{{ old('bio') }}</textarea>
        </div>

        {{-- メモ --}}
        <div>
            <label class="block font-semibold mb-1">メモ</label>
            <textarea name="note" rows="3" class="w-full border rounded px-3 py-2">{{ old('note') }}</textarea>
        </div>

        {{-- 備考 --}}
        <div>
            <label class="block font-semibold mb-1">備考</label>
            <textarea name="memo" rows="3" class="w-full border rounded px-3 py-2">{{ old('memo') }}</textarea>
        </div>

        {{-- 入社日 --}}
        <div>
            <label class="block font-semibold mb-1">入社日／入所日</label>
            <input type="date" name="joining_date" value="{{ old('joining_date') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- 退所日 --}}
        <div>
            <label class="block font-semibold mb-1">退所日／退職日</label>
            <input type="date" name="leaving_date" value="{{ old('leaving_date') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- 退校理由 --}}
        <div>
            <label class="block font-semibold mb-1">退校理由</label>
            <textarea name="leaving_reason" rows="3" class="w-full border rounded px-3 py-2">{{ old('leaving_reason') }}</textarea>
        </div>

        <div class="flex gap-3">
            <button class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                登録する
            </button>

            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                戻る
            </a>
        </div>

    </form>
</div>
@endsection
