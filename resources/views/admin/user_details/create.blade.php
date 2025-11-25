@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-3xl font-bold mb-6">詳細情報作成：{{ $user->name }}</h1>

        <form action="{{ route('admin.user_details.store', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <table class="w-full table-auto border-collapse">
                <tbody>

                    {{-- 生年月日 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                            生年月日
                        </th>
                        <td class="px-4 py-2">
                            <input type="date" name="birthday" value="{{ old('birthday') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    {{-- 性別 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">性別</th>
                        <td class="px-4 py-2">
                            <select name="gender" class="border rounded px-3 py-2 w-40">
                                <option value="">選択</option>
                                <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>男性</option>
                                <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>女性</option>
                                <option value="3" {{ old('gender') == 3 ? 'selected' : '' }}>不明</option>
                            </select>
                        </td>
                    </tr>

                    {{-- 電話番号1 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">電話番号1</th>
                        <td class="px-4 py-2">
                            <input type="text" name="phone1" value="{{ old('phone1') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    {{-- 電話番号2 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">電話番号2</th>
                        <td class="px-4 py-2">
                            <input type="text" name="phone2" value="{{ old('phone2') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    {{-- 郵便番号 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">郵便番号</th>
                        <td class="px-4 py-2">
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                class="border rounded px-3 py-2 w-40">
                        </td>
                    </tr>

                    {{-- 住所1 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">住所1</th>
                        <td class="px-4 py-2">
                            <input type="text" name="address1" value="{{ old('address1') }}"
                                class="border rounded px-3 py-2 w-full">
                        </td>
                    </tr>

                    {{-- 住所2 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">住所2</th>
                        <td class="px-4 py-2">
                            <input type="text" name="address2" value="{{ old('address2') }}"
                                class="border rounded px-3 py-2 w-full">
                        </td>
                    </tr>

                    {{-- 緊急連絡先 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">緊急連絡先</th>
                        <td class="px-4 py-2">
                            <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    {{-- 写真 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">写真</th>
                        <td class="px-4 py-2">
                            <input type="file" name="avatar_path" class="border rounded px-3 py-2 w-full"
                                accept="image/*" onchange="previewImage(event)">
                            <div class="mt-2">
                                <img id="avatarPreview" class="w-24 h-24 object-cover rounded-full" style="display:none;">
                            </div>
                        </td>
                    </tr>

                    {{-- テーマカラー --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">テーマカラー</th>
                        <td class="px-4 py-2">
                            <select name="theme_id" class="border rounded px-3 py-2 w-40">
                                <option value="">選択</option>
                                @foreach ($themes ?? [] as $theme)
                                    <option value="{{ $theme->id }}"
                                        {{ old('theme_id') == $theme->id ? 'selected' : '' }}>
                                        {{ $theme->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    {{-- ステータス --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">ステータス</th>
                        <td class="px-4 py-2">
                            <select name="status" class="border rounded px-3 py-2 w-40">
                                <option value="">選択</option>
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>アクティブ</option>
                                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>非アクティブ</option>
                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>停止</option>
                            </select>
                        </td>
                    </tr>

                    {{-- 自己紹介 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2 align-top">自己紹介</th>
                        <td class="px-4 py-2">
                            <textarea name="bio" class="border rounded px-3 py-2 w-full h-24">{{ old('bio') }}</textarea>
                        </td>
                    </tr>

                    {{-- 備考 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2 align-top">備考</th>
                        <td class="px-4 py-2">
                            <textarea name="memo" class="border rounded px-3 py-2 w-full h-24">{{ old('memo') }}</textarea>
                        </td>
                    </tr>

                    {{-- 入社/入校日 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">入社日/入校日</th>
                        <td class="px-4 py-2">
                            <input type="date" name="joining_date" value="{{ old('joining_date') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    {{-- 退社/退校日 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">退社日/退校日</th>
                        <td class="px-4 py-2">
                            <input type="date" name="leaving_date" value="{{ old('leaving_date') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    {{-- 理由 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">退社/退校理由</th>
                        <td class="px-4 py-2">
                            <input type="text" name="leaving_reason" value="{{ old('leaving_reason') }}"
                                class="border rounded px-3 py-2 w-full">
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    保存する
                </button>

                <a href="{{ route('admin.users.show', ['user' => $user->id, 'tab' => 'detail']) }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
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
