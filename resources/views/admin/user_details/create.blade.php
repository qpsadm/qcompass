@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">詳細情報作成：{{ $user->name }}</h1>

    <form action="{{ route('admin.user_details.store', $user->id) }}" method="POST" enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf

        <div>
            <label class="block font-semibold mb-1">生年月日</label>
            <input type="date" name="birthday" value="{{ old('birthday') }}" class="border px-3 py-2 rounded w-[250]">
        </div>

        <div>
            <label class="block font-semibold mb-1">性別</label>
            <select name="gender" class="border px-3 py-2 rounded w-[150]">
                <option value="">選択</option>
                <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>男性</option>
                <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>女性</option>
                <option value="3" {{ old('gender') == 3 ? 'selected' : '' }}>不明</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold mb-1">部署</label>
            <select name="divisions_id" class="border px-3 py-2 rounded w-[250]">
                <option value="">選択</option>
                @foreach($divisions as $division)
                <option value="{{ $division->id }}"
                    {{ old('divisions_id', $user->detail->divisions_id ?? '') == $division->id ? 'selected' : '' }}>
                    {{ $division->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold mb-1">電話番号1</label>
            <input type="text" name="phone1" value="{{ old('phone1') }}" class="border px-3 py-2 rounded w-[250]">
        </div>

        <div>
            <label class="block font-semibold mb-1">電話番号2</label>
            <input type="text" name="phone2" value="{{ old('phone2') }}" class="border px-3 py-2 rounded w-[250]">
        </div>

        <div>
            <label class="block font-semibold mb-1">郵便番号</label>
            <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="border px-3 py-2 rounded w-[150]">
        </div>

        <div>
            <label class="block font-semibold mb-1">住所1</label>
            <input type="text" name="address1" value="{{ old('address1') }}" class="border px-3 py-2 rounded w-full">
        </div>

        <div>
            <label class="block font-semibold mb-1">住所2</label>
            <input type="text" name="address2" value="{{ old('address2') }}" class="border px-3 py-2 rounded w-full">
        </div>

        <div>
            <label class="block font-semibold mb-1">緊急連絡先</label>
            <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}" class="border px-3 py-2 rounded w-[250]">
        </div>

        <div>
            <label class="block font-semibold mb-1">写真</label>
            <input type="file" name="avatar_path" class="border px-3 py-2 rounded w-full" accept="image/*" onchange="previewImage(event)">
            <div class="mt-2">
                <img id="avatarPreview" class="w-24 h-24 object-cover rounded-full" style="display:none;">
            </div>
        </div>

        <div>
            <label class="block font-semibold mb-1">テーマカラー</label>
            <select name="theme_id" class="border px-3 py-2 rounded w-[150]">
                <option value="">選択</option>
                @foreach($themes ?? [] as $theme)
                <option value="{{ $theme->id }}" {{ old('theme_id') == $theme->id ? 'selected' : '' }}>
                    {{ $theme->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold mb-1">ステータス</label>
            <select name="status" class="border px-3 py-2 rounded w-[150]">
                <option value="">選択</option>
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>アクティブ</option>
                <option value="0" {{ old('status') === "0" ? 'selected' : '' }}>非アクティブ</option>
                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>停止</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold mb-1">自己紹介</label>
            <textarea name="bio" class="border px-3 py-2 rounded w-full">{{ old('bio') }}</textarea>
        </div>

        <div>
            <label class="block font-semibold mb-1">備考</label>
            <textarea name="memo" class="border px-3 py-2 rounded w-full">{{ old('memo') }}</textarea>
        </div>

        <div>
            <label class="block font-semibold mb-1">入社日/入校日</label>
            <input type="date" name="joining_date" value="{{ old('joining_date') }}" class="border px-3 py-2 rounded w-[250]">
        </div>

        <div>
            <label class="block font-semibold mb-1">退社日/退校日</label>
            <input type="date" name="leaving_date" value="{{ old('leaving_date') }}" class="border px-3 py-2 rounded w-[250]">
        </div>

        <div>
            <label class="block font-semibold mb-1">退社/退校理由</label>
            <input type="text" name="leaving_reason" value="{{ old('leaving_reason') }}" class="border px-3 py-2 rounded w-full">
        </div>

        <div class="flex space-x-2 mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                作成
            </button>

            <a href="{{ route('admin.users.show', ['user' => $user->id, 'tab' => 'detail']) }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ユーザー詳細に戻る
            </a>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('avatarPreview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.style.display = 'block';
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>
@endsection
