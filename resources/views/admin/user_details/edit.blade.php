@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">ユーザー詳細編集</h1>

    @php
    $d = $user->detail;
    @endphp

    <form action="{{ route('admin.user_details.update', ['user' => $user->id, 'detail' => $d->id]) }}"
        method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        {{-- 部署 --}}
        <div>
            <label class="block font-semibold mb-1">部署</label>
            <input type="text" name="department" value="{{ old('department', $d->department ?? '') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- 電話番号 --}}
        <div>
            <label class="block font-semibold mb-1">電話番号1</label>
            <input type="text" name="phone1" value="{{ old('phone1', $d->phone1 ?? '') }}"
                class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block font-semibold mb-1">電話番号2</label>
            <input type="text" name="phone2" value="{{ old('phone2', $d->phone2 ?? '') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- 郵便番号・住所 --}}
        <div>
            <label class="block font-semibold mb-1">郵便番号</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $d->postal_code ?? '') }}"
                class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block font-semibold mb-1">住所1</label>
            <input type="text" name="address1" value="{{ old('address1', $d->address1 ?? '') }}"
                class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block font-semibold mb-1">住所2</label>
            <input type="text" name="address2" value="{{ old('address2', $d->address2 ?? '') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- 緊急連絡先 --}}
        <div>
            <label class="block font-semibold mb-1">緊急連絡先</label>
            <input type="text" name="emergency_contact" value="{{ old('emergency_contact', $d->emergency_contact ?? '') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- テーマカラー --}}
        <div>
            <label class="block font-semibold mb-1">テーマカラー</label>
            <select name="theme_id" class="w-full border rounded px-3 py-2">
                <option value="">選択してください</option>
                @foreach ($themes as $theme)
                <option value="{{ $theme->id }}" {{ old('theme_id', $d->theme_id ?? '') == $theme->id ? 'selected' : '' }}>
                    {{ $theme->name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- 自己紹介 --}}
        <div>
            <label class="block font-semibold mb-1">自己紹介</label>
            <textarea name="bio" rows="4" class="w-full border rounded px-3 py-2">{{ old('bio', $d->bio ?? '') }}</textarea>
        </div>

        {{-- メモ --}}
        <div>
            <label class="block font-semibold mb-1">メモ</label>
            <textarea name="note" rows="4" class="w-full border rounded px-3 py-2">{{ old('note', $d->note ?? '') }}</textarea>
        </div>

        {{-- 入社日 / 退社日 --}}
        <div>
            <label class="block font-semibold mb-1">入社日/入所日</label>
            <input type="date" name="joining_date" value="{{ old('joining_date', $d->joining_date ?? '') }}"
                class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block font-semibold mb-1">退所日/退職日</label>
            <input type="date" name="leaving_date" value="{{ old('leaving_date', $d->leaving_date ?? '') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- 退校理由 --}}
        <div>
            <label class="block font-semibold mb-1">退校/退職理由</label>
            <textarea name="leaving_reason" rows="4" class="w-full border rounded px-3 py-2">{{ old('leaving_reason', $d->leaving_reason ?? '') }}</textarea>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">
                詳細情報更新
            </button>
            <a href="{{ route('admin.users.edit', $user->id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                基本情報編集へ
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                ユーザー一覧へ
            </a>
        </div>
    </form>
</div>
@endsection
