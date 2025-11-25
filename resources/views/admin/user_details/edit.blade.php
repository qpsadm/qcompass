@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">ユーザー詳細情報編集：{{ $user->name }}</h1>

    <form action="{{ route('admin.user_details.update', ['user' => $user->id, 'detail' => $detail->id]) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-200">
                <tbody class="divide-y divide-gray-200">
                    {{-- 生年月日 --}}
                    <tr>
                        <th class="border p-2 text-left w-1/4 bg-gray-50">生年月日</th>
                        <td class="border p-2">
                            <input type="date" name="birthday"
                                value="{{ old('birthday', $detail->birthday?->format('Y-m-d')) }}"
                                class="w-40 border rounded px-2 py-1"> <!-- w-40 = 10rem = 約160px -->
                        </td>
                    </tr>

                    {{-- 性別 --}}
                    <tr>
                        <th class="border p-2 text-left bg-gray-50 w-1/4">性別</th>
                        <td class="border p-2">
                            <select name="gender" class="w-32 border rounded px-2 py-1">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('gender', $detail->gender) == 1 ? 'selected' : '' }}>男性</option>
                                <option value="2" {{ old('gender', $detail->gender) == 2 ? 'selected' : '' }}>女性</option>
                                <option value="9" {{ old('gender', $detail->gender) == 9 ? 'selected' : '' }}>その他</option>
                            </select>
                        </td>
                    </tr>

                    {{-- 電話番号1 --}}
                    <tr>
                        <th class="border p-2 text-left bg-gray-50">電話番号1</th>
                        <td class="border p-2">
                            <input type="text" name="phone1" value="{{ old('phone1', $detail->phone1) }}"
                                class="w-48 border rounded px-2 py-1">
                        </td>
                    </tr>

                    {{-- 電話番号2 --}}
                    <tr>
                        <th class="border p-2 text-left bg-gray-50">電話番号2</th>
                        <td class="border p-2">
                            <input type="text" name="phone2" value="{{ old('phone2', $detail->phone2) }}"
                                class="w-48 border rounded px-2 py-1">
                        </td>
                    </tr>

                    {{-- 郵便番号 --}}
                    <tr>
                        <th class="border p-2 text-left bg-gray-50">郵便番号</th>
                        <td class="border p-2">
                            <input type="text" name="postal_code" value="{{ old('postal_code', $detail->postal_code) }}"
                                class="w-48 border rounded px-2 py-1">
                        </td>
                    </tr>

                    {{-- 住所1 --}}
                    <tr>
                        <th class="border p-2 text-left bg-gray-50">住所1</th>
                        <td class="border p-2">
                            <input type="text" name="address1" value="{{ old('address1', $detail->address1) }}"
                                class="w-full border rounded px-2 py-1">
                        </td>
                    </tr>

                    {{-- 住所2 --}}
                    <tr>
                        <th class="border p-2 text-left bg-gray-50">住所2</th>
                        <td class="border p-2">
                            <input type="text" name="address2" value="{{ old('address2', $detail->address2) }}"
                                class="w-full border rounded px-2 py-1">
                        </td>
                    </tr>

                    {{-- 自己紹介 --}}
                    <tr>
                        <th class="border p-2 text-left bg-gray-50">自己紹介</th>
                        <td class="border p-2">
                            <textarea name="bio" rows="3" class="w-full border rounded px-2 py-1">{{ old('bio', $detail->bio) }}</textarea>
                        </td>
                    </tr>

                    {{-- 写真 --}}
                    <tr>
                        <th class="border p-2 text-left bg-gray-50">写真</th>
                        <td class="border p-2">
                            <input type="file" name="avatar_path" class="w-full border rounded px-2 py-1" accept="image/*" onchange="previewImage(event)">
                            <div class="mt-2">
                                <img id="avatarPreview" class="w-24 h-24 object-cover rounded-full"
                                    src="{{ $detail->avatar_path ? asset('storage/' . $detail->avatar_path) : '' }}"
                                    style="{{ $detail->avatar_path ? '' : 'display:none;' }}">
                            </div>
                        </td>
                    </tr>

                    {{-- 入社日／退所日 --}}
                    <tr>
                        <th class="border p-2 text-left bg-gray-50">入社日／退所日</th>
                        <td class="border p-2">
                            <div class="flex gap-2">
                                <input type="date" name="joining_date" value="{{ old('joining_date', $detail->joining_date?->format('Y-m-d')) }}"
                                    class="w-1/2 border rounded px-2 py-1">
                                <input type="date" name="leaving_date" value="{{ old('leaving_date', $detail->leaving_date?->format('Y-m-d')) }}"
                                    class="w-1/2 border rounded px-2 py-1">
                            </div>
                        </td>
                    </tr>

                    {{-- 退校理由 --}}
                    <tr>
                        <th class="border p-2 text-left bg-gray-50">退校理由</th>
                        <td class="border p-2">
                            <textarea name="leaving_reason" rows="3" class="w-full border rounded px-2 py-1">{{ old('leaving_reason', $detail->leaving_reason) }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex gap-3 mt-4">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                更新する
            </button>

            <a href="{{ route('admin.users.show', ['user' => $user->id, 'tab' => 'detail']) }}"
                class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
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
