@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-5xl">

    <h1 class="text-3xl font-bold mb-6">
        ユーザー詳細情報編集：{{ $user->name }}
    </h1>

    <form action="{{ route('admin.user_details.update', ['user' => $user->id, 'detail' => $detail->id]) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table class="w-full table-auto border-collapse">
            <tbody>

                {{-- 生年月日 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">生年月日</th>
                    <td class="px-4 py-2">
                        <input type="date" name="birthday"
                            value="{{ old('birthday', $detail->birthday?->format('Y-m-d')) }}"
                            class="border rounded px-3 py-2 w-48">
                    </td>
                </tr>

                {{-- 性別 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">性別</th>
                    <td class="px-4 py-2">
                        <select name="gender" class="border rounded px-3 py-2 w-32">
                            <option value="">選択してください</option>
                            <option value="1" {{ old('gender', $detail->gender) == 1 ? 'selected' : '' }}>男性</option>
                            <option value="2" {{ old('gender', $detail->gender) == 2 ? 'selected' : '' }}>女性</option>
                            <option value="9" {{ old('gender', $detail->gender) == 9 ? 'selected' : '' }}>その他</option>
                        </select>
                    </td>
                </tr>

                {{-- 電話番号1 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">電話番号1</th>
                    <td class="px-4 py-2">
                        <input type="text" name="phone1"
                            value="{{ old('phone1', $detail->phone1) }}"
                            class="border rounded px-3 py-2 w-64">
                    </td>
                </tr>

                {{-- 電話番号2 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">電話番号2</th>
                    <td class="px-4 py-2">
                        <input type="text" name="phone2"
                            value="{{ old('phone2', $detail->phone2) }}"
                            class="border rounded px-3 py-2 w-64">
                    </td>
                </tr>

                {{-- 緊急連絡先 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">緊急連絡先</th>
                    <td class="px-4 py-2">
                        <input type="text" name="emergency_contact"
                            value="{{ old('emergency_contact', $detail->emergency_contact) }}"
                            class="border rounded px-3 py-2 w-64">
                    </td>
                </tr>

                {{-- 郵便番号 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">郵便番号</th>
                    <td class="px-4 py-2">
                        <input type="text" name="postal_code"
                            value="{{ old('postal_code', $detail->postal_code) }}"
                            class="border rounded px-3 py-2 w-48">
                    </td>
                </tr>

                {{-- 住所1 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">住所1</th>
                    <td class="px-4 py-2">
                        <input type="text" name="address1"
                            value="{{ old('address1', $detail->address1) }}"
                            class="border rounded px-3 py-2 w-full">
                    </td>
                </tr>

                {{-- 住所2 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">住所2</th>
                    <td class="px-4 py-2">
                        <input type="text" name="address2"
                            value="{{ old('address2', $detail->address2) }}"
                            class="border rounded px-3 py-2 w-full">
                    </td>
                </tr>

                {{-- 自己紹介 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">自己紹介</th>
                    <td class="px-4 py-2">
                        <textarea name="bio" rows="3"
                            class="border rounded px-3 py-2 w-full">{{ old('bio', $detail->bio) }}</textarea>
                    </td>
                </tr>

                {{-- メモ --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">メモ</th>
                    <td class="px-4 py-2">
                        <textarea name="note" rows="3"
                            class="border rounded px-3 py-2 w-full">{{ old('note', $detail->note) }}</textarea>
                    </td>
                </tr>

                {{-- 備考 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">備考</th>
                    <td class="px-4 py-2">
                        <textarea name="memo" rows="3"
                            class="border rounded px-3 py-2 w-full">{{ old('memo', $detail->memo) }}</textarea>
                    </td>
                </tr>

                {{-- 写真 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">写真</th>
                    <td class="px-4 py-2">
                        <input type="file" name="avatar_path"
                            class="border rounded px-3 py-2 w-full"
                            accept="image/*" onchange="previewImage(event)">
                        <div class="mt-3">
                            <img id="avatarPreview"
                                class="w-24 h-24 object-cover rounded-full border"
                                src="{{ $detail->avatar_path ? asset('storage/' . $detail->avatar_path) : '' }}"
                                style="{{ $detail->avatar_path ? '' : 'display:none;' }}">
                        </div>
                    </td>
                </tr>

                {{-- 入社日 / 退所日 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">入社日 / 退所日</th>
                    <td class="px-4 py-2">
                        <div class="flex gap-3">
                            <input type="date" name="joining_date"
                                value="{{ old('joining_date', $detail->joining_date?->format('Y-m-d')) }}"
                                class="border rounded px-3 py-2 w-48">
                            <input type="date" name="leaving_date"
                                value="{{ old('leaving_date', $detail->leaving_date?->format('Y-m-d')) }}"
                                class="border rounded px-3 py-2 w-48">
                        </div>
                    </td>
                </tr>

                {{-- 退所理由 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">退所理由</th>
                    <td class="px-4 py-2">
                        <textarea name="leaving_reason" rows="3"
                            class="border rounded px-3 py-2 w-full">{{ old('leaving_reason', $detail->leaving_reason) }}</textarea>
                    </td>
                </tr>

                {{-- ユーザー状態 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                        ユーザー状態
                    </th>
                    <td class="px-4 py-2">
                        <select name="status" class="border rounded px-3 py-2 w-40">
                            <option value="">選択してください</option>

                            <option value="1"
                                {{ old('status', $detail->status) == 1 ? 'selected' : '' }}>
                                有効
                            </option>

                            <option value="0"
                                {{ (string) old('status', $detail->status) === '0' ? 'selected' : '' }}>
                                無効
                            </option>

                            <option value="2"
                                {{ old('status', $detail->status) == 2 ? 'selected' : '' }}>
                                停止
                            </option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- ボタン --}}
        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
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
        const file = event.target.files[0];
        const preview = document.getElementById('avatarPreview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>
@endsection
